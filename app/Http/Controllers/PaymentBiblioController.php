<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentBiblioController extends Controller
{
    public function index()
    {
        return view('bibliothecaire.payment');
    }

    public function show()
    {
        return view('bibliothecaire.payment');
    }
}
