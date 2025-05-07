<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
class Employe extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'employe';
    protected $primaryKey = 'id_employe';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['poste','date_embauche','salaire'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_employe', 'id_users');
    }
}