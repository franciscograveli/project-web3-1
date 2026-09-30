<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_categorias_sem_autenticacao(): void
    {
        Categoria::factory()->count(3)->create();

        $this->getJson('/api/categorias')->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_mostra_uma_categoria(): void
    {
        $categoria = Categoria::factory()->create();

        $this->getJson("/api/categorias/{$categoria->id}")
            ->assertOk()
            ->assertJsonPath('data.nome', $categoria->nome);
    }

    public function test_categoria_inexistente_retorna_404(): void
    {
        $this->getJson('/api/categorias/999')->assertNotFound();
    }

    public function test_nao_cadastra_sem_autenticacao(): void
    {
        $this->postJson('/api/categorias', ['nome' => 'Romance'])->assertUnauthorized();
    }

    public function test_cadastra_categoria(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/categorias', ['nome' => 'Romance', 'descricao' => 'Livros de romance'])
            ->assertCreated()
            ->assertJsonPath('data.nome', 'Romance');

        $this->assertDatabaseHas('categorias', ['nome' => 'Romance']);
    }

    public function test_nao_cadastra_categoria_com_nome_repetido(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Categoria::factory()->create(['nome' => 'Romance']);

        $this->postJson('/api/categorias', ['nome' => 'Romance'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('nome');
    }

    public function test_atualiza_categoria(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $categoria = Categoria::factory()->create();

        $this->putJson("/api/categorias/{$categoria->id}", ['nome' => 'Terror'])
            ->assertOk()
            ->assertJsonPath('data.nome', 'Terror');
    }

    public function test_exclui_categoria(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $categoria = Categoria::factory()->create();

        $this->deleteJson("/api/categorias/{$categoria->id}")->assertOk();
        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }

    public function test_nao_exclui_categoria_com_livros(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $livro = Livro::factory()->create();

        $this->deleteJson("/api/categorias/{$livro->categoria_id}")->assertConflict();
    }

    public function test_pagina_a_listagem(): void
    {
        Categoria::factory()->count(20)->create();

        $this->getJson('/api/categorias')
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 20)
            ->assertJsonPath('meta.per_page', 15)
            ->assertJsonPath('meta.last_page', 2);

        $this->getJson('/api/categorias?per_page=8&page=3')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonPath('meta.current_page', 3);
    }

    public function test_limita_per_page_ao_maximo_e_ao_minimo(): void
    {
        Categoria::factory()->count(20)->create();

        $this->getJson('/api/categorias?per_page=9999')->assertOk()->assertJsonPath('meta.per_page', 100);
        $this->getJson('/api/categorias?per_page=0')->assertOk()->assertJsonPath('meta.per_page', 1);
    }
}
