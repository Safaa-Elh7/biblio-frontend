<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\DigitalContent;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DigitalDownload extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'digital_download';
    protected $primaryKey = 'id_download';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_client','id_content','payment_id','date_download'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function content()
    {
        return $this->belongsTo(DigitalContent::class, 'id_content');
    }

    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'payment_id', 'id_paiement');
    }
}
