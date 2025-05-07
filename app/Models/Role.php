<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['code','guard_name','libelle'];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class, 'id_role', 'id_role');
    }
}
