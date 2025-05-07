<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Livraison extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'livraison';
    protected $primaryKey = 'id_livraison';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['date_livraison','statut_livraison','id_commande'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}
