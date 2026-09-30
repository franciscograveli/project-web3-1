<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    private function dados(array $extra = []): array
    {
        return array_merge([
            'nome' => 'Machado de Assis',
            'nacionalidade' => 'Brasileira',
            'nascimento' => '1839-06-21',
            'biografia' => 'Escritor brasileiro.',
        ], $extra);
    }

    public function test_lista_autores_sem_autenticacao(): void
    {
        Autor::factory()->count(2)->create();

        $this->getJson('/api/autores')->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_mostra_autor_com_seus_livros(): void
    {
        $livro = Livro::factory()->create();

        $this->getJson("/api/autores/{$livro->autor_id}")
            ->assertOk()
            ->assertJsonPath('data.livros.0.id', $livro->id);
    }

    public function test_nao_cadastra_sem_autenticacao(): void
    {
        $this->postJson('/api/autores', $this->dados())->assertUnauthorized();
    }

    public function test_cadastra_autor(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/autores', $this->dados())
            ->assertCreated()
            ->assertJsonPath('data.nome', 'Machado de Assis')
            ->assertJsonPath('data.nascimento', '1839-06-21');
    }

    public function test_valida_campos_obrigatorios(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/autores', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['nome', 'nascimento']);
    }

    public function test_atualiza_autor(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $autor = Autor::factory()->create();

        $this->putJson("/api/autores/{$autor->id}", $this->dados(['nome' => 'Clarice Lispector']))
            ->assertOk()
            ->assertJsonPath('data.nome', 'Clarice Lispector');
    }

    public function test_exclui_autor(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $autor = Autor::factory()->create();

        $this->deleteJson("/api/autores/{$autor->id}")->assertOk();
        $this->assertDatabaseMissing('autores', ['id' => $autor->id]);
    }

    public function test_nao_exclui_autor_com_livros(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $livro = Livro::factory()->create();

        $this->deleteJson("/api/autores/{$livro->autor_id}")->assertConflict();
    }

    public function test_pagina_a_listagem(): void
    {
        Autor::factory()->count(20)->create();

        $this->getJson('/api/autores')
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 20)
            ->assertJsonPath('meta.per_page', 15)
            ->assertJsonPath('meta.last_page', 2);

        $this->getJson('/api/autores?per_page=8&page=3')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonPath('meta.current_page', 3);
    }

    public function test_limita_per_page_ao_maximo_e_ao_minimo(): void
    {
        Autor::factory()->count(20)->create();

        $this->getJson('/api/autores?per_page=9999')->assertOk()->assertJsonPath('meta.per_page', 100);
        $this->getJson('/api/autores?per_page=0')->assertOk()->assertJsonPath('meta.per_page', 1);
    }
}
