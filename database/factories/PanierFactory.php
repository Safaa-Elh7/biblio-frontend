<?php

namespace Database\Factories;

use App\Models\Panier;
use App\Models\Client;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Panier>
 */
class PanierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Panier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */    public function definition(): array
    {
        $articlePrice = fake()->randomFloat(2, 10, 100);
        
        return [
            'id_client' => function () {
                return Client::inRandomOrder()->first()->id_client ?? Client::factory()->create()->id_client;
            },
            'id_article' => function () {
                return Article::inRandomOrder()->first()->id_article ?? Article::factory()->create()->id_article;
            },
            'total' => $articlePrice,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Define a state for carts with multiple items.
     *
     * @param int $count Number of items to add
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withMultipleItems(int $count = 3): Factory
    {
        return $this->afterCreating(function (Panier $panier) use ($count) {
            // Add additional items to the cart in a real app
            // The implementation would depend on your cart structure
            // This is just a placeholder for the concept
        });
    }
}
