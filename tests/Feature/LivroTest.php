<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    private function dados(array $extra = []): array
    {
        return array_merge([
            'titulo' => 'Dom Casmurro',
            'isbn' => '9788535910681',
            'ano_publicacao' => 1899,
            'descricao' => 'A história de Bentinho e Capitu.',
            'paginas' => 256,
            'autor_id' => Autor::factory()->create()->id,
            'categoria_id' => Categoria::factory()->create()->id,
        ], $extra);
    }

    public function test_lista_livros_com_autor_e_categoria(): void
    {
        $livro = Livro::factory()->create();

        $this->getJson('/api/livros')
            ->assertOk()
            ->assertJsonPath('data.0.autor.id', $livro->autor_id)
            ->assertJsonPath('data.0.categoria.id', $livro->categoria_id);
    }

    public function test_mostra_livro_com_autor_e_categoria(): void
    {
        $livro = Livro::factory()->create();

        $this->getJson("/api/livros/{$livro->id}")
            ->assertOk()
            ->assertJsonPath('data.autor.nome', $livro->autor->nome)
            ->assertJsonPath('data.categoria.nome', $livro->categoria->nome);
    }

    public function test_nao_cadastra_sem_autenticacao(): void
    {
        $this->postJson('/api/livros', $this->dados())->assertUnauthorized();
    }

    public function test_cadastra_livro(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/livros', $this->dados())
            ->assertCreated()
            ->assertJsonPath('data.titulo', 'Dom Casmurro')
            ->assertJsonStructure(['data' => ['autor', 'categoria']]);
    }

    public function test_nao_cadastra_livro_com_autor_inexistente(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/livros', $this->dados(['autor_id' => 999]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('autor_id');
    }

    public function test_atualiza_livro(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $livro = Livro::factory()->create();

        $this->putJson("/api/livros/{$livro->id}", $this->dados(['titulo' => 'Quincas Borba', 'isbn' => $livro->isbn]))
            ->assertOk()
            ->assertJsonPath('data.titulo', 'Quincas Borba');
    }

    public function test_exclui_livro(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $livro = Livro::factory()->create();

        $this->deleteJson("/api/livros/{$livro->id}")->assertOk();
        $this->assertDatabaseMissing('livros', ['id' => $livro->id]);
    }

    public function test_pagina_a_listagem(): void
    {
        Livro::factory()->count(20)->create();

        $this->getJson('/api/livros')
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 20)
            ->assertJsonPath('meta.per_page', 15)
            ->assertJsonPath('meta.last_page', 2);

        $this->getJson('/api/livros?per_page=8&page=3')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonPath('meta.current_page', 3);
    }

    public function test_limita_per_page_ao_maximo_e_ao_minimo(): void
    {
        Livro::factory()->count(20)->create();

        $this->getJson('/api/livros?per_page=9999')->assertOk()->assertJsonPath('meta.per_page', 100);
        $this->getJson('/api/livros?per_page=0')->assertOk()->assertJsonPath('meta.per_page', 1);
    }
}
