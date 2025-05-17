<?php

namespace App\Http\Controllers;

use App\Models\Livreur;
use App\Models\Livraison;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LivreurController extends Controller
{
    /**
     * Affiche le tableau de bord du livreur connecté
     */
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
     * Affiche la liste des livreurs pour l'administrateur
     */
    public function show()
    {
        $livreurs = Livreur::with('user')->get();
        return view('bibliothecaire.livreur', compact('livreurs'));
    }
    
    /**
     * Met à jour le statut de disponibilité d'un livreur
     */
    public function updateDisponibilite(Request $request)
    {
        $livreur = Livreur::findOrFail($request->id_livreur);
        $livreur->disponibilite = $request->disponibilite;
        $livreur->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Disponibilité mise à jour avec succès'
        ]);
    }
    
    /**
     * Récupérer les détails d'un livreur
     */
    public function getDetails($id)
    {
        $livreur = Livreur::with('user', 'livraisons')->findOrFail($id);
        
        return response()->json([
            'livreur' => $livreur,
            'fullName' => $livreur->fullName(),
            'totalLivraisons' => $livreur->totalLivraisons(),
            'email' => $livreur->user->email ?? 'N/A',
            'telephone' => $livreur->user->telephone ?? 'N/A',
            'adresse' => $livreur->user->adresse ?? 'N/A'
        ]);
    }
}
