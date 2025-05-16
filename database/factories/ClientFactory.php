<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */    public function definition(): array
    {
        return [
            'id_client' => function () {
                // Création d'un utilisateur standard
                return User::factory()->create()->id_users;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }    // État premium supprimé car les champs n'existent pas dans la table
}
