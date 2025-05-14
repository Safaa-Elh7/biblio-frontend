<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Reservation;
use App\Models\Emprunt;
use App\Models\DigitalContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Article extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'article';
    protected $primaryKey = 'id_article';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['titre','annee_pub','qte','prix_emprunt','description','langue','auteur','id_categorie','image'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_article');
    }

    public function paniers()
    {
        return $this->hasMany(Panier::class, 'id_article');
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'id_article');
    }

    public function digitalContent()
    {
        return $this->hasOne(DigitalContent::class, 'id_content');
    }
}
