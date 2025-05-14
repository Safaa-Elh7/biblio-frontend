<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Redirection intelligente selon le rôle de l'utilisateur
    public function index()
    {
        $user = Auth::user();
        $utilisateur = $user->utilisateur;
        
        if (!$utilisateur || !$utilisateur->role) {
            return view('home');
        }
        
        switch ($utilisateur->role->guard_name) {
            case 'bibliothecaire':
                return redirect()->route('bibliothecaire.dashboard');
            case 'livreur':
                return redirect()->route('livreur.dashboard');
            case 'employe':
                return redirect()->route('employe.dashboard');
            case 'client':
                return redirect()->route('client.home');
            default:
                return view('login')->with('error', 'Rôle non reconnu. Veuillez contacter l\'administrateur.');
        }
    }
}
