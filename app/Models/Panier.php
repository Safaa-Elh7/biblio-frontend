<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Panier extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'panier';
    protected $primaryKey = 'id_panier';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_client','total','id_article'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article');
    }
}
