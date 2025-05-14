<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['id','email','mot_de_passe','id_role'];
    protected $hidden = ['mot_de_passe','remember_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id_users');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function tokens()
    {
        return $this->hasMany(UserToken::class, 'id_user', 'id_utilisateur');
    }

    public function isLivreur()
    {
        return $this->role->guard_name === 'livreur';
    }

    public function isEmploye()
    {
        return $this->role->guard_name === 'employe';
    }

    public function isBibliothecaire()
    {
        return $this->role->guard_name === 'bibliothecaire';
    }

    public function isClient()
    {
        return $this->role->guard_name === 'client';
    }
}
