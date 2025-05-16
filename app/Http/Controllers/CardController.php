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
        $card[$request->id] = [
            "name" => $request->name,
            "quantity" => isset($card[$request->id]) ? $card[$request->id]['quantity'] + 1 : $request->quantity,
            "price" => $request->price,
            "image" => $request->image ?? 'https://via.placeholder.com/80x100?text=Livre',
        ];
        session()->put('card', $card);
        return redirect()->route('client.home')->with('success', 'Livre ajouté au card');
    }
}
