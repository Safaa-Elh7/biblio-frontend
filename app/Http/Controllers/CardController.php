<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    public function index()
    {
        // Récupérer le panier de la session
        $cart = session()->get('cart', []);
        
        // Calculer les totaux
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Calculer la TVA (4%)
        $tax = round($subtotal * 0.04);
        
        // Frais de livraison fixes
        $shipping = 20;
        
        // Total général
        $total = $subtotal + $tax;
        
        // Check if the fixed version exists, use it instead
        $view = file_exists(resource_path('views/client/card.blade.php')) ? 'client.card' : 'client.card';
        
        return view($view, compact('cart', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function processPayment(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'fullName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipCode' => 'required|string|max:20',
            'cardNumber' => 'required|string|max:19', // Format: XXXX XXXX XXXX XXXX
            'cardHolder' => 'required|string|max:255',
            'expiryDate' => 'required|string|max:5', // Format: MM/YY
            'cvv' => 'required|string|max:4',
        ]);
        
        // Récupérer le panier
        $cart = session()->get('cart', []);
        
        // Vérifier si le panier est vide
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }
        
        // Calculer les totaux
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $tax = round($subtotal * 0.04);
        $total = $subtotal + $tax;
        
        
            // Créer une nouvelle commande en base de données
            $order = new Order();
            $order->user_id = Auth::id() ?? null; // Si l'utilisateur est connecté
            $order->order_number = 'ORD-' . uniqid();
            $order->subtotal = $subtotal;
            $order->tax = $tax;
            $order->total = $total;
            $order->full_name = $validatedData['fullName'];
            $order->address = $validatedData['address'];
            $order->city = $validatedData['city'];
            $order->zip_code = $validatedData['zipCode'];
            // Masquer les informations de carte sensibles
            $order->payment_method = 'card';
            $order->card_last_four = substr(str_replace(' ', '', $validatedData['cardNumber']), -4);
            $order->status = 'completed';
            $order->save();
            
            // Enregistrer les éléments de la commande
            foreach ($cart as $id => $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->book_id = $id;
                $orderItem->name = $item['name'];
                $orderItem->price = $item['price'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->image = $item['image'] ?? null; // Sauvegarde de l'image
                $orderItem->author = $item['author'] ?? 'Non spécifié'; // Sauvegarde de l'auteur
                
                $orderItem->save();
            }
            
            // Vider le panier après la commande
            session()->forget('cart');
            
            // Rediriger vers une page de confirmation
            return redirect()->route('client.order.confirmation', ['order_number' => $order->order_number])
                ->with('success', 'Votre commande a été traitée avec succès!');
                
        
    }
}