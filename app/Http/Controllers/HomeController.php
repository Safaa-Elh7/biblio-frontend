<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     // Page d'accueil « client »
     public function index()
     {
         // ici tu pourras charger le catalogue, recommandations, etc.
         return view('home');
     }
}
