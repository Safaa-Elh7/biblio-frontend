<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Paiement extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'paiement';
    protected $primaryKey = 'id_paiement';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['methode','montant','date_paiement','statut','reference_id','id_commande'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}
