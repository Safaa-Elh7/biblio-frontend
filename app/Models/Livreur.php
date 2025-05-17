<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Livreur extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'livreur';
    protected $primaryKey = 'id_livreur';


    protected $fillable = [
        'zone_livraison',
        'moyen_transport',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_livreur', 'id_users');
    }
    
    /**
     * Relation avec les livraisons
     */
    public function livraisons(): HasMany
    {
        return $this->hasMany(Livraison::class, 'id_livreur', 'id_livreur');
    }
    
    /**
     * Obtenir le nombre total de livraisons effectuées
     */
    public function totalLivraisons()
    {
        return $this->livraisons()->count();
    }
    
    /**
     * Obtenir le nom complet du livreur
     */
    public function fullName()
    {
        if ($this->user) {
            return $this->user->name . ' ' . $this->user->prenom;
        }
        return 'N/A';
    }
}