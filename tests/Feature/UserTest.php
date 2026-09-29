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
}
