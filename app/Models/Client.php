<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Client extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'client';
    protected $primaryKey = 'id_client';
    public $incrementing = false;
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_client', 'id_users');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_client');
    }

    public function paniers()
    {
        return $this->hasMany(Panier::class, 'id_client');
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'id_client');
    }

    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'id_client');
    }

    public function digitalDownloads()
    {
        return $this->hasMany(DigitalDownload::class, 'id_client');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'id_client');
    }
}
