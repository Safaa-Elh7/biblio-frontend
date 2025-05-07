<?php

namespace App\Models;
    

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Livreur extends Authenticatable
{
use HasFactory,Notifiable;
protected $table = 'livreur';
protected $primaryKey = 'id_livreur';
public $incrementing = false;
public $timestamps = true;

protected $fillable = ['zone_livraison','moyen_transport'];

public function user()
{
    return $this->belongsTo(User::class, 'id_livreur', 'id_users');
}
}