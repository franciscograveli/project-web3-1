<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_usuarios(): void
    {
        Sanctum::actingAs(User::factory()->create());
        User::factory()->create();

        $this->getJson('/api/users')->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_usuario_atualiza_a_propria_conta(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->putJson("/api/users/{$user->id}", ['name' => 'Novo Nome', 'email' => $user->email])
            ->assertOk()
            ->assertJsonPath('data.name', 'Novo Nome');
    }

    public function test_usuario_nao_atualiza_conta_de_outro(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $outro = User::factory()->create();

        $this->putJson("/api/users/{$outro->id}", ['name' => 'Hack', 'email' => $outro->email])
            ->assertForbidden();
    }

    public function test_usuario_exclui_a_propria_conta(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->deleteJson("/api/users/{$user->id}")->assertOk();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_pagina_a_listagem(): void
    {
        Sanctum::actingAs(User::factory()->create());
        User::factory()->count(19)->create();

        $this->getJson('/api/users')
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 20)
            ->assertJsonPath('meta.per_page', 15)
            ->assertJsonPath('meta.last_page', 2);

        $this->getJson('/api/users?per_page=8&page=3')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonPath('meta.current_page', 3);
    }

    public function test_limita_per_page_ao_maximo_e_ao_minimo(): void
    {
        Sanctum::actingAs(User::factory()->create());
        User::factory()->count(19)->create();

        $this->getJson('/api/users?per_page=9999')->assertOk()->assertJsonPath('meta.per_page', 100);
        $this->getJson('/api/users?per_page=0')->assertOk()->assertJsonPath('meta.per_page', 1);
    }
}
