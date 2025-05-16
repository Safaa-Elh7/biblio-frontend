<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Article;
use App\Models\Client;
use App\Models\Panier;
use App\Models\Commande;
use App\Models\Emprunt;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des catégories (5 catégories)
        $categories = Categorie::factory(5)->create();
        
        // Création des articles (15 articles)
        // Répartition entre livres physiques et numériques
        $articles = collect();
        
        $articles = $articles->merge(Article::factory(10)->physical()->create([
            'id_categorie' => $categories->random()->id_categorie,
        ]));
        
        $articles = $articles->merge(Article::factory(5)->digital()->create([
            'id_categorie' => $categories->random()->id_categorie,
        ]));
        
        // Création des clients (5 clients)
        $clients = collect();
        $clients = $clients->merge(Client::factory(5)->create());
        
        // Création des paniers (10 paniers)
        $paniers = Panier::factory(10)->create([
            'id_client' => $clients->random()->id_client,
            'id_article' => $articles->random()->id_article,
        ]);
        
        // Création des commandes (5 commandes)
        $commandes = collect();
        $commandes = $commandes->merge(Commande::factory(5)->create([
            'id_panier' => $paniers->random()->id_panier,
        ]));
        
        // Création des emprunts (8 emprunts)
        $emprunts = collect();
        $emprunts = $emprunts->merge(Emprunt::factory(5)->create([
            'id_client' => $clients->random()->id_client,
            'id_article' => $articles->random()->id_article,
        ]));
        
        $emprunts = $emprunts->merge(Emprunt::factory(3)->overdue()->create([
            'id_client' => $clients->random()->id_client,
            'id_article' => $articles->random()->id_article,
        ]));
        
        $this->command->info('Les données de test ont été créées avec succès!');
        $this->command->info('- 5 catégories');
        $this->command->info('- 15 articles (10 physiques, 5 numériques)');
        $this->command->info('- 5 clients');
        $this->command->info('- 10 paniers');
        $this->command->info('- 5 commandes');
        $this->command->info('- 8 emprunts (5 réguliers, 3 en retard)');
    }
}
