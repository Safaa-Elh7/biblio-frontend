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
     * @param string[] ...$allowedCodes  ex. 'livreur','employe','client'
     */
    public function handle(Request $request, Closure $next, ...$allowedCodes)
    {
        $user = Auth::user();
        $code = $user->utilisateur->role->code;  // lit le code stocké en BDD

        if (! in_array($code, $allowedCodes)) {
            abort(403, "Accès interdit pour le rôle “{$code}”.");
        }

        return $next($request);
    }
}
