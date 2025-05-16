<?php

namespace Database\Factories;

use App\Models\Emprunt;
use App\Models\Client;
use App\Models\Article;
use App\Models\Panier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Emprunt>
 */
class EmpruntFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Emprunt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateEmprunt = fake()->dateTimeBetween('-3 months', 'now');
        $dureeJours = fake()->numberBetween(7, 30);
        $dateRetourPrevue = (clone $dateEmprunt)->modify("+{$dureeJours} days");
        
        $etat = fake()->randomElement(['BORROWED', 'RETURNED', 'OVERDUE']);
        $total = fake()->randomFloat(2, 10, 100);
        
        return [
            'id_client' => function () {
                return Client::inRandomOrder()->first()->id_client ?? Client::factory()->create()->id_client;
            },
            'id_article' => function () {
                return Article::inRandomOrder()->first()->id_article ?? Article::factory()->create()->id_article;
            },
            'date_emprunt' => $dateEmprunt,
            'date_retour_prevue' => $dateRetourPrevue,
            'etat' => $etat,
            'total' => $total,
            'nb_renouvellements' => fake()->numberBetween(0, 3),
            'id_panier' => function () {
                return fake()->boolean(70) ? Panier::inRandomOrder()->first()->id_panier ?? null : null;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Define a state for overdue loans.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function overdue(): Factory
    {
        return $this->state(function (array $attributes) {
            $dateEmprunt = fake()->dateTimeBetween('-2 months', '-1 month');
            $dateRetourPrevue = (clone $dateEmprunt)->modify("+15 days");
            
            return [
                'date_emprunt' => $dateEmprunt,
                'date_retour_prevue' => $dateRetourPrevue,
                'etat' => 'OVERDUE',
                'nb_renouvellements' => 0,
            ];
        });
    }
}
