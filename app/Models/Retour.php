<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Emprunt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;use App\Models\Amende;

class Retour extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'retour';
    protected $primaryKey = 'id_retour';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['date_retour_reelle','etat_livre','payback','id_emprunt','id_employe'];

    public function emprunt()
    {
        return $this->belongsTo(Emprunt::class, 'id_emprunt');
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe');
    }

    public function amendes()
    {
        return $this->hasMany(Amende::class, 'id_retour');
    }
}
