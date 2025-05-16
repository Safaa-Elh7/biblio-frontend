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
        // Récupérer le panier actuel de la session
        $cart = session()->get('cart', []);

        // Générer une clé unique pour chaque livre ajouté
        // Utiliser l'ID du livre et un timestamp unique
        $uniqueKey = $request->id;
        // Vérifier si le livre existe déjà dans le panier
        if (isset($cart[$uniqueKey])) {
            // Si le livre existe déjà, augmenter juste sa quantité
            $cart[$uniqueKey]['quantity']++;
            $message = "La quantité du livre \"" . $cart[$uniqueKey]['name'] . "\" a été augmentée dans votre panier";
        } else {
            // Si le livre n'existe pas encore, l'ajouter comme nouveau livre
            $cart[$uniqueKey] = [
                "name" => $request->name,
                "quantity" => 1, // Initialiser à 1, ignorer $request->quantity
                "price" => $request->price,
                "image" => $request->image ,
                "author" => $request->author ?? 'Non spécifié',
            ];
            $message = "Le livre \"" . $request->name . "\" a été ajouté à votre panier";
        }
        
        // Mettre à jour le panier dans la session
        session()->put('cart', $cart);
        
        // Déterminer la redirection appropriée
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => $message,
                'cart' => $cart
            ]);
        }
        
        // Pour les requêtes normales, rediriger avec un message de succès
        if ($request->has('redirect_to_panier') && $request->redirect_to_panier) {
            return redirect()->route('client.panier.index')->with('success', $message);
        } else {
            if ($request->has('redirect_back') && $request->redirect_back) {
                return back()->with('success', $message);
            } else {
                // Comportement par défaut : rester sur la page du livre
                return back()->with('success', $message);
            }
        }
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        if (isset($cart[$id])) {
            if ($request->action === 'increment') {
                $cart[$id]['quantity'] += 1;
                $message = "Quantité du livre \"" . $cart[$id]['name'] . "\" augmentée";
            } elseif ($request->action === 'decrement' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
                $message = "Quantité du livre \"" . $cart[$id]['name'] . "\" diminuée";
            }
            session()->put('cart', $cart);
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message ?? "Panier mis à jour", 
                'cart' => $cart
            ]);
        }
        
        return redirect()->route('client.panier.index')->with('success', $message ?? "Panier mis à jour");
    }

    public function removeFromCart(Request $request)
    {
        $message = "Livre retiré du panier";
        
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $message = "Le livre \"" . $cart[$request->id]['name'] . "\" a été retiré de votre panier";
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => $message
            ]);
        }
        
        return redirect()->route('client.panier.index')->with('success', $message);
    }
    
    public function getCart()
    {
        $cart = session()->get('cart', []);

        return response()->json(['cart' => $cart]);
    }
}