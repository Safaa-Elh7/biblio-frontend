<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        return view('client.book');
    }
    
    public function show($id)
    {
        $response = Http::get("http://localhost:8081/api/articles/{$id}");
        if ($response->successful()) {
            $book = $response->json();
            
            // Vérifier si l'image existe et la formater correctement
            if (isset($book['image']) && !empty($book['image'])) {
                // Si l'image est déjà un chemin complet, on le laisse tel quel
                if (filter_var($book['image'], FILTER_VALIDATE_URL)) {
                    // Ne rien faire, c'est déjà une URL complète
                } 
                // Si c'est un chemin relatif, on s'assure qu'il est correctement formaté
                else {
                    // Supprimer les éventuels slashes au début pour éviter les doublons
                    $book['image'] = ltrim($book['image'], '/');
                }
            } else {
                // Si pas d'image, utiliser une image par défaut
                $book['image'] = 'default-book.jpg';
            }
            
            return view('client.book', compact('book'));
        }
        
        abort(404);
    }
}
