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
        $cart[$request->id] = [
            "name" => $request->name,
            "quantity" => isset($cart[$request->id]) ? $cart[$request->id]['quantity'] + 1 : $request->quantity,
            "price" => $request->price,
            "image" => $request->image ?? 'https://via.placeholder.com/80x100?text=Livre',
        ];
        session()->put('cart', $cart);
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
        return redirect()->route('client.panier.index');
    }

    public function removeFromCart(Request $request)
    {
        // Logique pour retirer un livre du panier
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return response()->json(['success' => 'Livre retiré du panier']);
    }
}
