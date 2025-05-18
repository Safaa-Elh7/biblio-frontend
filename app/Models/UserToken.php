<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserToken extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $table = 'user_tokens';
    protected $primaryKey = 'id_token';
    public $timestamps = false;

    protected $fillable = ['id_user','token','expires_at','created_at'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_user', 'id_utilisateur');
    }
    
}
