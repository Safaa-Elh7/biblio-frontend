<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livreur;
use App\Models\Employe;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function create()
    {
        $roles = Role::all();    // récupère tous tes rôles (id_role, code, libelle…)
        return view('auth.register', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'prenom'         => ['required', 'string', 'max:100'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'date_naissance' => ['nullable', 'date'],
            'telephone'      => ['nullable', 'string', 'max:20'],
            'adresse'        => ['nullable', 'string', 'max:255'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
            'id_role'        => ['required', 'exists:roles,id_role'],
        ]);

        // 1) Création du User
        $user = User::create([
            'name'           => $request->name,
            'prenom'         => $request->prenom,
            'email'          => $request->email,
            'date_naissance' => $request->date_naissance,
            'telephone'      => $request->telephone,
            'adresse'        => $request->adresse,
            'password'       => Hash::make($request->password),
        ]);

        // 2) Création de la ligne dans la table `utilisateur`
        $user->utilisateur()->create([
            'email'        => $request->email,
            'mot_de_passe' => Hash::make($request->password),
            'id_role'      => $request->id_role,
        ]);

        // 3) Création du sous‐modèle métier selon le code du rôle
        $role = Role::findOrFail($request->id_role);
        switch($role->code) {
            case 'livreur':
                $user->livreur()->create();
                $redirect = 'livreur.dashboard';
                break;
            case 'employe':
                $user->employe()->create();
                $redirect = 'employe.dashboard';
                break;
            default:
                $user->client()->create();
                $redirect = 'home';
                break;
        }

        event(new Registered($user));
        auth()->login($user);

        return redirect()->route($redirect);
    }
}
