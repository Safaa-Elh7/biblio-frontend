<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index()
    {
        return view('client.panier');
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        // Vérifier si le livre existe déjà dans le panier
        if (isset($cart[$request->id])) {
            // Si le livre existe déjà, augmenter juste sa quantité
            $cart[$request->id]['quantity']++;
        } else {
            // Si le livre n'existe pas encore, l'ajouter comme nouveau livre
            $cart[$request->id] = [
                "name" => $request->name,
                "quantity" => 1,  // Initialiser à 1, ne pas utiliser $request->quantity qui pourrait être null
                "price" => $request->price,
                "image" => $request->image ?? 'https://via.placeholder.com/80x100?text=Livre',
                "author" => $request->author ?? 'Non spécifié',
            ];
        }
        
        session()->put('cart', $cart);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'cart' => $cart]);
        }
        
        return redirect()->route('client.home')->with('success', 'Livre ajouté au panier');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        if (isset($cart[$id])) {
            if ($request->action === 'increment') {
                $cart[$id]['quantity'] += 1;
            } elseif ($request->action === 'decrement' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
            }
            session()->put('cart', $cart);
        }
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'cart' => $cart]);
        }
        
        return redirect()->route('client.panier.index');
    }

    public function removeFromCart(Request $request)
    {
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('client.panier.index');
    }
    
    public function getCart()
    {
        $cart = session()->get('cart', []);
        return response()->json(['cart' => $cart]);
    }
}