<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Models\Livreur;
use App\Models\User;
use App\Models\Utilisateur;
use Dflydev\DotAccessData\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LivreurController extends Controller
{
    public function index()
    {
        // Récupérer le livreur connecté
        $user = Auth::user();
        $livreur = Livreur::with('user')->where('id_livreur', $user->id_users)->first();
        
        if (!$livreur) {
            return redirect()->route('welcome')->with('error', 'Profil de livreur non trouvé');
        }
        
        // Récupérer les livraisons du livreur
        $livraisons = Livraison::where('id_livreur', $livreur->id_livreur)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Statistiques
        $stats = [
            'total_livraisons' => $livraisons->count(),
            'livraisons_en_cours' => $livraisons->where('statut', 'en_cours')->count(),
            'livraisons_terminees' => $livraisons->where('statut', 'livré')->count(),
            'note_moyenne' => $livreur->rating ?? 0
        ];
        
        return view('livreur.dashboard', compact('livreur', 'livraisons', 'stats'));
    }

    /**
     * Affiche la liste de tous les livreurs pour le bibliothécaire
     */
    public function show()
    {
        // Utiliser Eloquent avec eager loading pour charger les relations
        $livreurs = Livreur::with('user')->get();
        
        // Transformer les données pour les rendre compatibles avec la vue
        $formattedLivreurs = $livreurs->map(function($livreur) {
            return (object) [
                'id_livreur' => $livreur->id_livreur,
                'zone_livraison' => $livreur->zone_livraison,
                'moyen_transport' => $livreur->moyen_transport,
                'nom' => $livreur->user ? $livreur->user->name : 'N/A',
                'prenom' => $livreur->user ? $livreur->user->prenom : '',
                'email' => $livreur->user ? $livreur->user->email : 'N/A',
                'telephone' => $livreur->user ? $livreur->user->telephone : 'N/A'
            ];
        });
            
        return view('bibliothecaire.livreur', ['livreurs' => $formattedLivreurs]);
    }

    /**
     * Stocke un nouveau livreur dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'zone_livraison' => 'required|string|max:100',
            'moyen_transport' => 'required|string|max:100',
        ]);

        // Démarrer une transaction pour s'assurer que toutes les opérations réussissent
        DB::beginTransaction();

        try {
            // Créer l'utilisateur
            $user = new User();
            $user->name = $validatedData['nom'];
            $user->prenom = $validatedData['prenom'];
            $user->email = $validatedData['email'];
            $user->telephone = $validatedData['telephone'];
            $user->password = Hash::make($validatedData['password']);
            $user->id_role = 3; // 3 est l'ID du rôle livreur
            $user->save();

            // Créer le livreur associé
            $livreur = new Livreur();
            $livreur->id_livreur = $user->id_users;
            $livreur->zone_livraison = $validatedData['zone_livraison'];
            $livreur->moyen_transport = $validatedData['moyen_transport'];
            $livreur->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Livreur ajouté avec succès']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupère les détails d'un livreur spécifique pour l'édition
     */
    public function edit($id)
    {
        $livreur = Livreur::with('user')
            ->where('id_livreur', $id)
            ->first();

        if (!$livreur) {
            return response()->json(['success' => false, 'message' => 'Livreur non trouvé'], 404);
        }

        // Formater les données pour qu'elles soient compatibles avec le JavaScript
        $formattedLivreur = [
            'id_livreur' => $livreur->id_livreur,
            'zone_livraison' => $livreur->zone_livraison,
            'moyen_transport' => $livreur->moyen_transport,
            'id_users' => $livreur->id_livreur, // Même valeur que id_livreur selon la relation
            'nom' => $livreur->user ? $livreur->user->name : 'N/A',
            'prenom' => $livreur->user ? $livreur->user->prenom : '',
            'email' => $livreur->user ? $livreur->user->email : 'N/A',
            'telephone' => $livreur->user ? $livreur->user->telephone : 'N/A'
        ];

        return response()->json(['success' => true, 'livreur' => $formattedLivreur]);
    }
    
    /**
     * Récupère les détails d'un livreur pour l'affichage
     */
    public function getLivreur($id)
    {
        return $this->edit($id); // Réutiliser la même logique que edit()
    }

    /**
     * Met à jour un livreur existant
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id, 'id_users'),
            ],
            'telephone' => 'required|string|max:20',
            'zone_livraison' => 'required|string|max:100',
            'moyen_transport' => 'required|string|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        // Démarrer une transaction
        DB::beginTransaction();

        try {
            // Mettre à jour l'utilisateur
            $user = User::findOrFail($id);
            $user->name = $validatedData['nom'];
            $user->prenom = $validatedData['prenom'];
            $user->email = $validatedData['email'];
            $user->telephone = $validatedData['telephone'];
            
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
            
            $user->save();

            // Mettre à jour le livreur associé
            $livreur = Livreur::where('id_livreur', $id)->first();
            $livreur->zone_livraison = $validatedData['zone_livraison'];
            $livreur->moyen_transport = $validatedData['moyen_transport'];
            $livreur->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Livreur mis à jour avec succès']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Supprime un livreur
     */
    public function destroy($id)
    {
        try {
            // Grâce à la relation onDelete('cascade'), supprimer l'utilisateur supprimera 
            // également l'entrée correspondante dans la table livreur
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json(['success' => true, 'message' => 'Livreur supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()], 500);
        }
    }
}