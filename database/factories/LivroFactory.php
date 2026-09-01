<?php

namespace Database\Factories;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => fake()->sentence(4),
            'autor' => fake()->name(),
            'editora' => fake()->company(),
            'data_pub' => fake()->date(),
            'genero' => fake()->randomElement([
                'Romance',
                'Ficção',
                'Fantasia',
                'Suspense',
                'Terror',
                'Aventura',
                'Biografia',
                'História',
                'Ciência',
                'Tecnologia',
            ]),
            'idioma' => fake()->randomElement([
                'Português',
                'Inglês',
                'Espanhol',
                'Francês',
            ]),
            'qtd_pag' => fake()->numberBetween(50, 1000),
            'formato' => fake()->randomElement([
                'fisico',
                'ebook',
            ]),
            'tipo_capa' => fake()->randomElement([
                'brochura',
                'capa_dura',
            ]),
            'sinopse' => fake()->paragraph(3),
        ];
    }
}
