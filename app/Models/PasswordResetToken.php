<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';
    public    $primaryKey = 'email';
    public    $incrementing = false;
    public    $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    /**
     * L’utilisateur concerné (par email).
     */
    public function utilisateur()
    {
        return $this->belongsTo(
            Utilisateur::class,
            'email',
            'email'
        );
    }
}
