<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserBiblioController extends Controller
{
    public function index()
    {
        return view('client.bibliothecaire');
    }

    public function show()
    {
        return view('bibliothecaire.user');
    }
}
