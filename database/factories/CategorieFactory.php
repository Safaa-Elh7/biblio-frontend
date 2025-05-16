<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Categorie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */    public function definition(): array
    {
        // Nous utilisons une approche avec un compteur pour garantir l'unicité
        static $counter = 0;
        $counter++;
        
        $typeNames = [
            'Roman', 'Science-Fiction', 'Policier', 'Biographie', 
            'Histoire', 'Fantasy', 'Jeunesse', 'Économie', 'Philosophie',
            'Art', 'Cuisine', 'Voyage', 'Psychologie', 'Technologie'
        ];
        
        // Ajouter un suffixe unique basé sur le compteur
        $typeName = $typeNames[$counter % count($typeNames)] . ' ' . $counter;

        return [
            'type_nom' => $typeName,
            'description' => fake()->paragraph(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Categorie $categorie) {
            // Anything to execute after making the model
        })->afterCreating(function (Categorie $categorie) {
            // Anything to execute after creating the model
        });
    }
}
