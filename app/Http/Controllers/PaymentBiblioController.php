<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentBiblioController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('bibliothecaire.payment', compact('orders'));
    }
    
    /**
     * Export payments data as PDF
     */
    public function export(Request $request)
    {
        // Récupérer les mêmes données que la méthode show mais sans pagination
        $query = Order::orderBy('created_at', 'desc');
        
        // Appliquer les mêmes filtres que la méthode show
        if ($request->has('payment_method') && $request->payment_method != 'all') {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('total', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'date_asc':
                    $query->reorder('created_at', 'asc');
                    break;
                case 'amount_asc':
                    $query->reorder('total', 'asc');
                    break;
                case 'amount_desc':
                    $query->reorder('total', 'desc');
                    break;
            }
        }
        
        $orders = $query->get();
        
        // Obtenir les utilisateurs associés
        $userIds = $orders->pluck('user_id')->filter()->unique()->toArray();
        $users = User::whereIn('id_users', $userIds)->get()->keyBy('id_users');
        
        // TODO: Implémenter la génération du PDF
        // En attendant, retourner un message
        return back()->with('info', 'La fonctionnalité d\'exportation PDF sera bientôt disponible.');
    }

    public function show(Request $request)
    {
        // Récupération des commandes payées pour afficher comme paiements
        $query = Order::orderBy('created_at', 'desc');
        
        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('total', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtrage par méthode de paiement
        if ($request->has('payment_method') && $request->payment_method != 'all') {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Gestion du tri
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'date_asc':
                    $query->reorder('created_at', 'asc');
                    break;
                case 'date_desc':
                    // C'est déjà le tri par défaut
                    break;
                case 'amount_asc':
                    $query->reorder('total', 'asc');
                    break;
                case 'amount_desc':
                    $query->reorder('total', 'desc');
                    break;
            }
        }
        
        // Pagination
        $orders = $query->paginate(10);
        
        // Obtenir les utilisateurs (clients) associés aux commandes
        $userIds = $orders->pluck('user_id')->filter()->unique()->toArray();
        $users = User::whereIn('id_users', $userIds)->get()->keyBy('id_users');
        
        return view('bibliothecaire.payment', compact('orders', 'users'));
    }
}
