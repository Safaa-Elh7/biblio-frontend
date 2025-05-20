<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserBiblioController extends Controller
{
    public function index()
    {
        return view('client.bibliothecaire');
    }

    /**
     * Affiche la liste de tous les utilisateurs pour le bibliothécaire
     */
    public function show()
    {
        // Récupérer tous les utilisateurs, sauf les bibliothécaires (s'ils ont un rôle spécifique)
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('bibliothecaire.user', compact('users'));
    }
    
    /**
     * Affiche un utilisateur spécifique
     */
    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['success' => true, 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
    }
    
    /**
     * Stocke un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'password' => 'required|string|min:8',
        ]);

        try {
            // Créer l'utilisateur
            $user = new User();
            $user->name = $validatedData['name'];
            $user->prenom = $validatedData['prenom'];
            $user->email = $validatedData['email'];
            $user->telephone = $validatedData['telephone'] ?? null;
            $user->adresse = $validatedData['adresse'] ?? null;
            $user->date_naissance = $validatedData['date_naissance'] ?? null;
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            return response()->json(['success' => true, 'message' => 'Utilisateur ajouté avec succès', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Met à jour un utilisateur existant
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id, 'id_users'),
            ],
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $validatedData['name'];
            $user->prenom = $validatedData['prenom'];
            $user->email = $validatedData['email'];
            $user->telephone = $validatedData['telephone'] ?? $user->telephone;
            $user->adresse = $validatedData['adresse'] ?? $user->adresse;
            $user->date_naissance = $validatedData['date_naissance'] ?? $user->date_naissance;
            
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
            
            $user->save();

            return response()->json(['success' => true, 'message' => 'Utilisateur mis à jour avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Supprime un utilisateur
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json(['success' => true, 'message' => 'Utilisateur supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()], 500);
        }
    }
}
