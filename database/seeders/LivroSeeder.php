<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Livro;
use Illuminate\Database\Seeder;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livros = [
            ['Dom Casmurro', '9788535910681', 1899, 256, 'Machado de Assis', 'Romance', 'A história de Bentinho e Capitu.'],
            ['Memórias Póstumas de Brás Cubas', '9788535910667', 1881, 208, 'Machado de Assis', 'Romance', 'Memórias narradas por um defunto autor.'],
            ['O Hobbit', '9788595084742', 1937, 336, 'J. R. R. Tolkien', 'Fantasia', 'A aventura de Bilbo Bolseiro.'],
            ['Eu, Robô', '9788576572008', 1950, 320, 'Isaac Asimov', 'Ficção Científica', 'Contos sobre as três leis da robótica.'],
            ['Código Limpo', '9788576082675', 2008, 425, 'Robert C. Martin', 'Tecnologia', 'Boas práticas para escrever código legível.'],
        ];

        foreach ($livros as [$titulo, $isbn, $ano, $paginas, $autor, $categoria, $descricao]) {
            Livro::create([
                'titulo' => $titulo,
                'isbn' => $isbn,
                'ano_publicacao' => $ano,
                'descricao' => $descricao,
                'paginas' => $paginas,
                'autor_id' => Autor::where('nome', $autor)->value('id'),
                'categoria_id' => Categoria::where('nome', $categoria)->value('id'),
            ]);
        }
    }
}
