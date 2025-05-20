<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Livreur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BibliothecaireController extends Controller
{
    public function index()
    {
        return view('bibliothecaire.dashboard');
    }

    public function dashboard()
    {
        // Statistiques générales
        $totalLivres = Article::count();
        $totalCommandes = Order::count();
        $totalLivreurs = Livreur::count();
        $totalClients = User::role('client')->count();

        // Commandes par mois pour le graphique
        $commandesParMois = Order::select(
            DB::raw('DATE_FORMAT(date_commande, "%M %Y") as mois'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('mois')
        ->orderBy('date_commande')
        ->get();

        // Livres les plus populaires
        $livresPopulaires = Article::select('articles.*', DB::raw('COUNT(order_items.id) as total_ventes'))
            ->join('order_items', 'articles.id_article', '=', 'order_items.article_id')
            ->groupBy('articles.id_article')
            ->orderBy('total_ventes', 'desc')
            ->limit(5)
            ->get();

        // Dernières commandes
        $dernieresCommandes = Order::with('client')
            ->orderBy('date_commande', 'desc')
            ->limit(5)
            ->get();

        return view('bibliothecaire.dashboard', compact(
            'totalLivres',
            'totalCommandes',
            'totalLivreurs',
            'totalClients',
            'commandesParMois',
            'livresPopulaires',
            'dernieresCommandes'
        ));
    }
}