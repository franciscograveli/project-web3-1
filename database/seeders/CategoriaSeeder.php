<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Romance', 'descricao' => 'Obras de ficção em prosa com narrativa longa'],
            ['nome' => 'Fantasia', 'descricao' => 'Histórias com elementos mágicos ou sobrenaturais'],
            ['nome' => 'Ficção Científica', 'descricao' => 'Histórias baseadas em ciência e tecnologia'],
            ['nome' => 'Tecnologia', 'descricao' => 'Livros técnicos sobre programação e computação'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
