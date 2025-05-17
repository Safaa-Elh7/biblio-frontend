<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Obtient l'URL complète d'une image.
     *
     * @param string|null $imagePath Chemin de l'image ou URL
     * @param string $default URL de l'image par défaut si $imagePath est null ou vide
     * @return string URL complète de l'image
     */
    public static function getImageUrl($imagePath, $default = 'https://via.placeholder.com/150x200?text=Livre')
    {
        if (empty($imagePath)) {
            return $default;
        }
        
        // Si c'est déjà une URL complète
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        
        // Si c'est un chemin sans slash au début
        $imagePath = ltrim($imagePath, '/');
        
        // Retourne l'URL complète
        return asset('storage/' . $imagePath);
    }
}
