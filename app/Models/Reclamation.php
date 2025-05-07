<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reclamation extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'reclamation';
    protected $primaryKey = 'id_reclamation';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['objet','raison','date_reclamation','statut','id_client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}
