<?php

namespace Database\Factories;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Autor>
 */
class AutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->name(),
            'nacionalidade' => fake()->country(),
            'nascimento' => fake()->date(max: '-18 years'),
            'biografia' => fake()->optional()->paragraph(),
        ];
    }
}
