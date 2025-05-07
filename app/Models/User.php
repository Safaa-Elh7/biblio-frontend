<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ----------------------------------------------------
// Modèle User (table users)
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'prenom',
        'date_naissance',
        'telephone',
        'adresse',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client()
    {
        return $this->hasOne(Client::class, 'id_client', 'id_users');
    }

    public function bibliothecaire()
    {
        return $this->hasOne(Bibliothecaire::class, 'id_bibliothecaire', 'id_users');
    }

    public function livreur()
    {
        return $this->hasOne(Livreur::class, 'id_livreur', 'id_users');
    }

    public function employe()
    {
        return $this->hasOne(Employe::class, 'id_employe', 'id_users');
    }

    public function utilisateur()
    {
        return $this->hasOne(Utilisateur::class, 'id', 'id_users');
    }

    public function userTokens()
    {
        return $this->hasMany(UserToken::class, 'id_user', 'id_utilisateur');
    }
}
