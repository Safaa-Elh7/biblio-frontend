<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        return view('client.card');
    }

    public function addToCard(Request $request)
    {
        $card = session()->get('card', []);
        
        // Vérifier si le livre existe déjà dans le card
        if (isset($card[$request->id])) {
            // Si le livre existe déjà, augmenter juste sa quantité
            $card[$request->id]['quantity']++;
        } else {
            // Si le livre n'existe pas encore, l'ajouter comme nouveau livre
            $card[$request->id] = [
                "name" => $request->name,
                "quantity" => $request->quantity,
                "price" => $request->price,
                "image" => $request->image ?? 'https://via.placeholder.com/80x100?text=Livre',
                "author" => $request->author ?? 'Non spécifié',
            ];
        }
        
        session()->put('card', $card);
        return redirect()->route('client.home')->with('success', 'Livre ajouté au card');
    }
}
