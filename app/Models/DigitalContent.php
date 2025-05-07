<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\DigitalDownload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DigitalContent extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'digital_content';
    protected $primaryKey = 'id_content';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_article','url','format'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article');
    }

    public function downloads()
    {
        return $this->hasMany(DigitalDownload::class, 'id_content');
    }
}
