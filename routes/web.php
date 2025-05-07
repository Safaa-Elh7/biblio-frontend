<?php

use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LivreurController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\FacturationController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class,'index'])
     ->middleware('auth')
     ->name('home');

    
     
     // Tableau de bord Livreur
     Route::middleware(['auth','role:livreur'])
          ->prefix('livreur')
          ->name('livreur.')
          ->group(function(){
              Route::get('dashboard', [LivreurController::class,'index'])
                   ->name('dashboard');
          });
     
     // Tableau de bord Employé
     Route::middleware(['auth','role:employe'])
          ->prefix('employe')
          ->name('employe.')
          ->group(function(){
              Route::get('dashboard', [EmployeController::class,'index'])
                   ->name('dashboard');
          });
     
     // Tableau de bord Client
     Route::middleware(['auth','role:client'])
          ->prefix('client')
          ->name('client.')
          ->group(function(){
              Route::get('dashboard', [ClientController::class,'index'])
                   ->name('dashboard');
          });
     

require __DIR__.'/auth.php';
