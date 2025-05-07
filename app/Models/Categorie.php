<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Categorie extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'categorie';
    protected $primaryKey = 'id_categorie';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['description','type_nom'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'id_categorie');
    }
}
