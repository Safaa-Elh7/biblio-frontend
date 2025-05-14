<?php

namespace App\Http\Controllers\Auth; // ou simplement App\Http\Controllers si tu l'as créé là

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // On peut rediriger selon le rôle principal
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        }
        if ($user->hasRole('bibliothecaire')) {
            return redirect()->route('dashboard.bibliothecaire');
        }
        if ($user->hasRole('livreur')) {
            return redirect()->route('dashboard.livreur.commandes');
        }
        if ($user->hasRole('employe')) {
            return redirect()->route('employe.retours');
        }
        // Par défaut client
        return redirect()->route('home');
    }
}
