<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $utilisateur = $user->utilisateur;
        
        if (!$utilisateur || !$utilisateur->role) {
            return redirect()->route('home');
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
                return redirect()->route('login')->with('error', 'Rôle non reconnu. Veuillez contacter l\'administrateur.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
