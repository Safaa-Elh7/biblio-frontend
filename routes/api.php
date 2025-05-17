<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les livreurs
Route::middleware(['auth:sanctum'])->group(function () {
    // Route pour obtenir les détails d'un livreur
    Route::get('/livreurs/{id}', [\App\Http\Controllers\LivreurController::class, 'getDetails']);
    
    // Routes pour les livraisons
    Route::get('/livraisons', [\App\Http\Controllers\LivraisonController::class, 'index']);
    Route::post('/livraisons/{id}/update-status', [\App\Http\Controllers\LivraisonController::class, 'updateStatus']);
    Route::delete('/livraisons/{id}', [\App\Http\Controllers\LivraisonController::class, 'destroy']);
});
