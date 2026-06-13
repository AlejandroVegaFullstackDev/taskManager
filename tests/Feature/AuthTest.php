<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user_and_returns_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Ana',
            'email'    => 'ana@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);

        $this->assertDatabaseHas('users', ['email' => 'ana@example.com']);
    }

    public function test_login_with_valid_credentials_returns_token(): void
    {
        // UserFactory crea el usuario con la contraseña 'password'.
        User::factory()->create(['email' => 'ana@example.com']);

        $response = $this->postJson('/api/login', [
            'email'    => 'ana@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_login_with_invalid_credentials_returns_401(): void
    {
        User::factory()->create(['email' => 'ana@example.com']);

        $response = $this->postJson('/api/login', [
            'email'    => 'ana@example.com',
            'password' => 'incorrecta',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment(['error' => 'Credenciales inválidas']);
    }

    public function test_protected_route_requires_token(): void
    {
        $this->getJson('/api/tasks')->assertStatus(401);
    }
}
