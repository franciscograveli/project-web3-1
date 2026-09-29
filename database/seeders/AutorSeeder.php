<?php

namespace Database\Seeders;

use App\Models\Autor;
use Illuminate\Database\Seeder;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autores = [
            [
                'nome' => 'Machado de Assis',
                'nacionalidade' => 'Brasileira',
                'nascimento' => '1839-06-21',
                'biografia' => 'Escritor brasileiro, fundador da Academia Brasileira de Letras.',
            ],
            [
                'nome' => 'J. R. R. Tolkien',
                'nacionalidade' => 'Britânica',
                'nascimento' => '1892-01-03',
                'biografia' => 'Escritor e professor, autor de O Senhor dos Anéis.',
            ],
            [
                'nome' => 'Isaac Asimov',
                'nacionalidade' => 'Americana',
                'nascimento' => '1920-01-02',
                'biografia' => 'Escritor e bioquímico, conhecido por suas obras de ficção científica.',
            ],
            [
                'nome' => 'Robert C. Martin',
                'nacionalidade' => 'Americana',
                'nascimento' => '1952-12-05',
                'biografia' => 'Engenheiro de software, autor de Código Limpo.',
            ],
        ];

        foreach ($autores as $autor) {
            Autor::create($autor);
        }
    }
}
