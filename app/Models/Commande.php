<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Panier;
use App\Models\Paiement;
use App\Models\Livraison;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Commande extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'commande';
    protected $primaryKey = 'id_commande';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_panier','date_commande','total_complet','total_avance','id_emprunt'];

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'id_panier');
    }

    public function emprunt()
    {
        return $this->belongsTo(Emprunt::class, 'id_emprunt');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_commande');
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class, 'id_commande');
    }
}
