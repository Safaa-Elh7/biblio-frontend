<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function index()
    {
        return view('client.article');
    }

    public function show()
    {
        
        return view('bibliothecaire.article');
    }
}
