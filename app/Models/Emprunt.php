<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Article;
use App\Models\Retour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Emprunt extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'emprunt';
    protected $primaryKey = 'id_emprunt';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['date_emprunt','date_retour_prevue','etat','id_client','id_article','id_panier','total','nb_renouvellements'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article');
    }

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'id_panier');
    }

    public function retours()
    {
        return $this->hasMany(Retour::class, 'id_emprunt');
    }

}
