<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reservation extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'reservation';
    protected $primaryKey = 'id_reservation';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['date_reservation','statut','id_client','id_article'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article');
    }
}
