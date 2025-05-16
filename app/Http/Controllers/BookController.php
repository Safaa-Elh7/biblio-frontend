<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('client.book', compact('book'));
    }

    abort(404);
}

}
