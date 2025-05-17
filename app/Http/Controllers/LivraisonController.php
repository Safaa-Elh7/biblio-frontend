<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LivraisonController extends Controller
{
    /**
     * Affiche la liste des livraisons du livreur connecté
     */
    public function index()
    {
        $user = Auth::user();
        $livreur = \App\Models\Livreur::where('id_livreur', $user->id_users)->first();
        
        if (!$livreur) {
            return response()->json(['error' => 'Profil de livreur non trouvé'], 404);
        }
        
        $livraisons = Livraison::with('commande', 'commande.client')
            ->where('id_livreur', $livreur->id_livreur)
            ->get();
            
        return response()->json($livraisons);
    }
    
    /**
     * Met à jour le statut d'une livraison
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $livreur = \App\Models\Livreur::where('id_livreur', $user->id_users)->first();
        
        if (!$livreur) {
            return response()->json(['success' => false, 'message' => 'Profil de livreur non trouvé'], 404);
        }
        
        $livraison = Livraison::where('id_livraison', $id)
            ->where('id_livreur', $livreur->id_livreur)
            ->first();
        
        if (!$livraison) {
            return response()->json(['success' => false, 'message' => 'Livraison non trouvée ou non autorisée'], 404);
        }
        
        try {
            $livraison->statut = $request->statut;
            $livraison->save();
            
            // Si la livraison est marquée comme livrée, mettre à jour la commande également
            if ($request->statut === 'livré' && $livraison->id_commande) {
                $commande = \App\Models\Commande::find($livraison->id_commande);
                if ($commande) {
                    $commande->statut = 'livrée';
                    $commande->save();
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Statut de livraison mis à jour avec succès',
                'livraison' => $livraison
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du statut de la livraison: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du statut'
            ], 500);
        }
    }
    
    /**
     * Supprime une livraison
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $livreur = \App\Models\Livreur::where('id_livreur', $user->id_users)->first();
        
        if (!$livreur) {
            return response()->json(['success' => false, 'message' => 'Profil de livreur non trouvé'], 404);
        }
        
        $livraison = Livraison::where('id_livraison', $id)
            ->where('id_livreur', $livreur->id_livreur)
            ->first();
        
        if (!$livraison) {
            return response()->json(['success' => false, 'message' => 'Livraison non trouvée ou non autorisée'], 404);
        }
        
        try {
            $livraison->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Livraison supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la livraison: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de la livraison'
            ], 500);
        }
    }
}
