<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuditLog extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'audit_log';
    protected $primaryKey = 'id_log';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['table_name','record_id','action','id_client','timestamp'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}
