<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Panier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commande::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */    public function definition(): array
    {
        $totalComplet = fake()->randomFloat(2, 20, 500);
        $totalAvance = $totalComplet * fake()->randomFloat(2, 0.2, 1);
        
        return [
            'id_panier' => function () {
                return Panier::inRandomOrder()->first()->id_panier ?? Panier::factory()->create()->id_panier;
            },
            'date_commande' => fake()->dateTimeBetween('-1 month', 'now'),
            'total_complet' => $totalComplet,
            'total_avance' => $totalAvance,
            'id_emprunt' => null, // Sera défini plus tard si nécessaire
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }    // Suppression des états qui utilisent des champs non existants
}
