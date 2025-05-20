<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderBiblioController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->orderBy('created_at', 'desc')->get();
        
        // Obtenir les utilisateurs (clients) associés aux commandes
        $userIds = $orders->pluck('user_id')->filter()->unique()->toArray();
        $users = User::whereIn('id_users', $userIds)->get()->keyBy('id_users');
        
        return view('bibliothecaire.orders', compact('orders', 'users'));
    }
    
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        // Get user info if available
        $user = null;
        if ($order->user_id) {
            $user = User::find($order->user_id);
        }
        
        return view('bibliothecaire.order_details', compact('order', 'user'));
    }
}
