<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Cabeceras con un token JWT válido para un usuario nuevo.
     *
     * @return array<string, string>
     */
    private function authHeaders(): array
    {
        $token = JWTAuth::fromUser(User::factory()->create());

        return ['Authorization' => "Bearer {$token}"];
    }

    public function test_requires_authentication(): void
    {
        $this->getJson('/api/tasks')->assertStatus(401);
    }

    public function test_lists_tasks(): void
    {
        Task::factory()->count(3)->create();

        $this->withHeaders($this->authHeaders())
            ->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_creates_task(): void
    {
        $payload = [
            'title'       => 'Comprar pan',
            'description' => 'En la tienda de la esquina',
            'status'      => 'pendiente',
        ];

        $this->withHeaders($this->authHeaders())
            ->postJson('/api/tasks', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Comprar pan']);

        $this->assertDatabaseHas('tasks', ['title' => 'Comprar pan']);
    }

    public function test_create_fails_validation_when_incomplete(): void
    {
        $this->withHeaders($this->authHeaders())
            ->postJson('/api/tasks', ['title' => 'Sólo título'])
            ->assertStatus(422);
    }

    public function test_create_rejects_invalid_status(): void
    {
        $this->withHeaders($this->authHeaders())
            ->postJson('/api/tasks', [
                'title'       => 'Tarea',
                'description' => 'desc',
                'status'      => 'en_progreso', // no permitido
            ])
            ->assertStatus(422);
    }

    public function test_shows_a_task(): void
    {
        $task = Task::factory()->create();

        $this->withHeaders($this->authHeaders())
            ->getJson("/api/tasks/{$task->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

    public function test_returns_404_for_missing_task(): void
    {
        $this->withHeaders($this->authHeaders())
            ->getJson('/api/tasks/9999')
            ->assertStatus(404)
            ->assertJsonFragment(['error' => 'Tarea no encontrada']);
    }

    public function test_updates_a_task(): void
    {
        $task = Task::factory()->create(['status' => 'pendiente']);

        $this->withHeaders($this->authHeaders())
            ->putJson("/api/tasks/{$task->id}", ['status' => 'completada'])
            ->assertStatus(200)
            ->assertJsonFragment(['status' => 'completada']);

        $this->assertDatabaseHas('tasks', [
            'id'     => $task->id,
            'status' => 'completada',
        ]);
    }

    public function test_deletes_a_task(): void
    {
        $task = Task::factory()->create();

        $this->withHeaders($this->authHeaders())
            ->deleteJson("/api/tasks/{$task->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
