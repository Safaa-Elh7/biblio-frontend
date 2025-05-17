<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Affiche la page de confirmation d'une commande.
     *
     * @param  string  $order_number
     * @return \Illuminate\Http\Response
     */
    public function confirmation($order_number)
    {
        // Récupérer la commande par son numéro de commande
        $order = Order::where('order_number', $order_number)
            ->with('items') // Charger également les éléments de la commande
            ->firstOrFail();
        
        // Si l'utilisateur est connecté, vérifier qu'il est autorisé à voir cette commande
        // (Si l'utilisateur n'est pas connecté, on autorise quand même car la commande peut être faite sans compte)
        if (Auth::check() && Auth::id() !== $order->user_id && !Auth::Utilisateur()->isBibliothecaire()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette commande.');
        }
        
        return view('client.order.confirmation', compact('order'));
    }
    
    /**
     * Affiche l'historique des commandes de l'utilisateur connecté.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir votre historique de commandes.');
        }
        
        // Récupérer les commandes de l'utilisateur, les plus récentes en premier
        $orders = Order::where('user_id', Auth::id())
            ->with('items')  // Préchargement des items pour éviter les requêtes N+1
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Collecter tous les IDs de livres de toutes les commandes
        $bookIds = collect();
        foreach ($orders as $order) {
            $bookIds = $bookIds->merge($order->items->pluck('book_id'));
        }
        
        // Récupérer tous les livres associés à toutes les commandes
        $books = Article::whereIn('id_article', $bookIds->unique())
            ->get();
        
        return view('client.order.history', compact('orders', 'books'));
    }
    
    /**
     * Affiche les détails d'une commande spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir les détails de cette commande.');
        }
        
        // Récupérer la commande de l'utilisateur par son ID
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id()) // Sécurité: seulement les commandes de l'utilisateur
            ->with('items')
            ->firstOrFail();
        
        return view('client.order.show', compact('order'));
    }
    
    /**
     * Permet à un administrateur de voir toutes les commandes.
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        // Vérifier que l'utilisateur est un admin
        if (!Auth::check() || !Auth::Utilisateur()->isBibliothecaire()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Récupérer toutes les commandes, les plus récentes en premier
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Permet à un administrateur de voir les détails d'une commande.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminShow($id)
    {
        // Vérifier que l'utilisateur est un admin
        if (!Auth::check() || !Auth::Utilisateur()->isBibliothecaire()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Récupérer la commande par son ID, avec les relations
        $order = Order::with(['items', 'user'])
            ->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Permet à un administrateur de mettre à jour le statut d'une commande.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminUpdateStatus(Request $request, $id)
    {
        // Vérifier que l'utilisateur est un admin
        if (!Auth::check() || !Auth::Utilisateur()->isBibliothecaire()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Valider la requête
        $validatedData = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        // Récupérer la commande et mettre à jour son statut
        $order = Order::findOrFail($id);
        $order->status = $validatedData['status'];
        $order->save();
        
        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Le statut de la commande a été mis à jour avec succès.');
    }
    
    /**
     * Recherche de commandes par numéro de commande ou par nom de client.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $searchTerm = $request->input('search');
        
        // Si l'utilisateur est un admin, recherche dans toutes les commandes
        if (Auth::Utilisateur()->isBibliothecaire()) {
            $orders = Order::where('order_number', 'LIKE', "%{$searchTerm}%")
                ->orWhere('full_name', 'LIKE', "%{$searchTerm}%")
                ->orderBy('created_at', 'desc')
                ->paginate(15);
                
            return view('admin.orders.index', compact('orders', 'searchTerm'));
        } 
        // Sinon, recherche uniquement dans les commandes de l'utilisateur
        else {
            $orders = Order::where('user_id', Auth::id())
                ->with('items')
                ->where(function($query) use ($searchTerm) {
                    $query->where('order_number', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('full_name', 'LIKE', "%{$searchTerm}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Collecter tous les IDs de livres des commandes trouvées
            $bookIds = collect();
            foreach ($orders as $order) {
                $bookIds = $bookIds->merge($order->items->pluck('book_id'));
            }
            
            // Récupérer tous les livres associés aux commandes
            $books = Article::whereIn('id_article', $bookIds->unique())->get();
                
            return view('client.order.history', compact('orders', 'books', 'searchTerm'));
        }
    }
}