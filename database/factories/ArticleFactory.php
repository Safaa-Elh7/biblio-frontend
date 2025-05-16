<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'prix_emprunt' => fake()->randomFloat(2, 10, 100),
            'auteur' => fake()->name(),
            'annee_pub' => fake()->year(),
            'langue' => fake()->randomElement(['Français', 'Anglais', 'Arabe', 'Espagnol']),
            'id_categorie' => function () {
                return Categorie::inRandomOrder()->first()->id_categorie ?? Categorie::factory()->create()->id_categorie;
            },
            'image' => 'books/' . fake()->randomElement(['book1.jpg', 'book2.jpg', 'book3.jpg', 'book4.jpg', 'book5.jpg']),
            'qte' => fake()->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }    /**
     * Define a state for digital books.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function digital(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'description' => fake()->paragraph(3) . ' [Format numérique]',
            ];
        });
    }

    /**
     * Define a state for physical books.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function physical(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'description' => fake()->paragraph(3) . ' [Livre physique]',
            ];
        });
    }
}
