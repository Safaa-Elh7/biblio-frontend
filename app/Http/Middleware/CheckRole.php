<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * @param Request  $request
     * @param \Closure $next
     * @param string[] ...$roles  ex. 'livreur','employe','client','bibliothecaire'
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();
        $utilisateur = $user->utilisateur;
        
        if (!$utilisateur || !$utilisateur->role) {
            return redirect()->route('login')->with('error', 'Votre compte ne possède pas de rôle. Veuillez contacter l\'administrateur.');
        }
        
        $userRole = $utilisateur->role->guard_name;
        
        // Vérifier si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (in_array($userRole, $roles)) {
            return $next($request);
        }
        
        return redirect()->route('welcome')->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
    }
}
