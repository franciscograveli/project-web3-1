<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_consegue_se_registrar(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Aluno',
            'email' => 'aluno@email.com',
            'password' => 'senha1234',
            'password_confirmation' => 'senha1234',
        ]);

        $response->assertCreated()->assertJsonStructure(['user' => ['id', 'name', 'email'], 'token']);
        $this->assertDatabaseHas('users', ['email' => 'aluno@email.com']);
    }

    public function test_usuario_consegue_fazer_login(): void
    {
        User::factory()->create(['email' => 'aluno@email.com', 'password' => 'senha1234']);

        $this->postJson('/api/login', ['email' => 'aluno@email.com', 'password' => 'senha1234'])
            ->assertOk()
            ->assertJsonStructure(['user', 'token']);
    }

    public function test_login_com_senha_errada_falha(): void
    {
        User::factory()->create(['email' => 'aluno@email.com', 'password' => 'senha1234']);

        $this->postJson('/api/login', ['email' => 'aluno@email.com', 'password' => 'errada123'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }

    public function test_usuario_logado_consegue_ver_seus_dados(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->getJson('/api/user')->assertOk()->assertJsonPath('data.id', $user->id);
    }

    public function test_rota_protegida_sem_token_retorna_401(): void
    {
        $this->getJson('/api/user')->assertUnauthorized();
    }
}
