<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LivreurController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\BibliothecaireController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\FacturationController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardBiblioController;
use App\Http\Controllers\OrderBiblioController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PaymentBiblioController;
use App\Http\Controllers\UserBiblioController;
use App\Models\Livreur;
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
})->name('welcome');

// Route pour tester la directive @bookImage
Route::get('/test-image', function () {
     return view('test.image-test');
})->name('test.image');

Route::get('/dashboard', function () {
     return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour le bibliothécaire
Route::middleware(['auth', 'role:bibliothecaire'])
     ->prefix('bibliothecaire')
     ->name('bibliothecaire.')
     ->group(function () {
          Route::get('dashboard', [BibliothecaireController::class, 'index'])
               ->name('dashboard');
     });

Route::middleware(['auth', 'role:livreur'])
     ->prefix('livreur')
     ->name('livreur.')
     ->group(function () {
          Route::get('dashboard', [LivreurController::class, 'index'])
               ->name('dashboard');
          Route::post('update-disponibilite', [LivreurController::class, 'updateDisponibilite'])
               ->name('update.disponibilite');
          Route::get('details/{id}', [LivreurController::class, 'getDetails'])
               ->name('details');
     });

Route::middleware(['auth', 'role:employe'])
     ->prefix('employe')
     ->name('employe.')
     ->group(function () {
          Route::get('dashboard', [EmployeController::class, 'index'])
               ->name('dashboard');
     });

Route::middleware(['auth', 'role:client'])
     ->prefix('client')
     ->name('client.')
     ->group(function () {
          Route::get('home', [ClientController::class, 'index'])
               ->name('home');
     });

// Route::get('/home', [HomeController::class,'index'])
//      ->middleware('auth')
//      ->name('home');
Route::get('/home', [BookController::class, 'index'])->name('client.book.index');

Route::get('/client/book/{id}', [BookController::class, 'show'])->name('client.book.show');
Route::get('/client/panier', [PanierController::class, 'index'])->name('client.panier.index');
Route::post('/client/panier/add', [PanierController::class, 'addToCart'])->name('client.panier.add');
Route::post('/client/panier/update', [PanierController::class, 'update'])->name('client.panier.update');
Route::post('/client/panier/remove', [PanierController::class, 'removeFromCart'])->name('client.panier.remove');
Route::get('/client/panier/get', [PanierController::class, 'getCart'])->name('client.panier.getCart');

// Affichage du formulaire de paiement
Route::get('/client/card', [CardController::class, 'index'])->name('client.card.index');
// Traitement du paiement (formulaire POST)
Route::post('/client/card/process-payment', [CardController::class, 'processPayment'])->name('client.card.processPayment');
// Page de confirmation de commande
Route::get('/client/order/confirmation/{order_number}', [OrderController::class, 'confirmation'])->name('client.order.confirmation');

// Historique et détails des commandes (protégé par auth)
Route::middleware(['auth'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/orders', [OrderController::class, 'history'])->name('order.history');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('order.search');
    });
Route::get('/dashboard', [DashboardBiblioController::class, 'index'])->name('bibliothecaire.dashboard.index');
Route::get('/bibliothecaire/article', [App\Http\Controllers\ArticleController::class, 'show'])->name('bibliothecaire.article.index');
Route::get('/articles', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::post('/articles', [App\Http\Controllers\ArticleController::class, 'store'])->name('articles.store');
Route::match(['put', 'post'], '/articles/{id}', [App\Http\Controllers\ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('articles.destroy');
Route::get('/api/articles/{id}', [App\Http\Controllers\ArticleController::class, 'getArticle'])->name('api.articles.show');
// Routes pour la gestion des livreurs (CRUD)
Route::get('/bibliothecaire/livreurs', [LivreurController::class, 'show'])->name('bibliothecaire.livreur.index');
Route::post('/bibliothecaire/livreurs', [LivreurController::class, 'store'])->name('bibliothecaire.livreur.store');
Route::get('/bibliothecaire/livreurs/{id}', [LivreurController::class, 'edit'])->name('bibliothecaire.livreur.edit');
Route::put('/bibliothecaire/livreurs/{id}', [LivreurController::class, 'update'])->name('bibliothecaire.livreur.update');
Route::delete('/bibliothecaire/livreurs/{id}', [LivreurController::class, 'destroy'])->name('bibliothecaire.livreur.destroy');
Route::get('/users', [UserBiblioController::class, 'show'])->name('bibliothecaire.user.index');
Route::get('bibliothecaire/orders', [OrderBiblioController::class, 'index'])->name('bibliothecaire.order.show');


Route::get('/orders', [OrderController::class, 'history'])->name('order.history');

// API testing routes
Route::get('/test/api-connection', function() {
    return view('test.api-connection');
})->name('test.api-connection');
Route::get('/check-storage-link', [ArticleController::class, 'checkStorageLink'])->name('check-storage-link');
Route::get('/test-api-connection', [ArticleController::class, 'testApiConnection'])->name('test-api-connection');

require __DIR__ . '/auth.php';
