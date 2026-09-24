<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('categorias')->insert([
            [
                'nome' => 'Fisica',
                'descricao' => 'Descrição da Categoria 1',
                'created_at' => now(),
            ],
            [
                'nome' => 'Quimica',
                'descricao' => 'Descrição da Categoria 2',
                'created_at' => now(),
            ],
            [
                'nome' => 'Ficção',
                'descricao' => 'Descrição da Categoria 3',
                'created_at' => now(),
            ],
        ]);
    }
}
