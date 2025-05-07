<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Bibliothecaire extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'bibliothecaire';
    protected $primaryKey = 'id_bibliothecaire';
    public $incrementing = false;
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_bibliothecaire', 'id_users');
    }
}
