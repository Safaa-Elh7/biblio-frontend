<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardBiblioController extends Controller
{
    public function index()
    {
        return view('bibliothecaire.dashboard');
    }

    public function show()
    {
        return view('bibliothecaire.bibliothecaire');
    }
}
