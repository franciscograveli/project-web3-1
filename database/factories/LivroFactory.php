<?php

namespace Database\Factories;

use App\Models\Autor;
use App\Models\Categoria;
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
            'titulo' => fake()->sentence(3),
            'isbn' => fake()->unique()->isbn13(),
            'ano_publicacao' => fake()->numberBetween(1900, 2025),
            'descricao' => fake()->sentence(),
            'paginas' => fake()->numberBetween(50, 500),
            'autor_id' => Autor::factory(),
            'categoria_id' => Categoria::factory(),
        ];
    }
}
