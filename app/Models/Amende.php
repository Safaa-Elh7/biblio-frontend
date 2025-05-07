<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Retour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Amende extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'amende';
    protected $primaryKey = 'id_amende';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['montant','raison','date_emission','payee','id_retour'];

    public function retour()
    {
        return $this->belongsTo(Retour::class, 'id_retour');
    }
}
