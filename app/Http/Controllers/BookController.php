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
            
            // Nous n'avons plus besoin de vérifier ou formater l'image ici
            // car notre directive @bookImage et la classe ImageHelper s'en chargeront
            
            return view('client.book', compact('book'));
        }
        
        abort(404);
    }
}
