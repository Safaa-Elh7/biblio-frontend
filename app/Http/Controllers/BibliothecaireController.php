<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BibliothecaireController extends Controller
{
    public function index()
    {
        return view('bibliothecaire.dashboard');
    }
}