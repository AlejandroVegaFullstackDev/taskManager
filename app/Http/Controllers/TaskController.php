<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $tasks,
    ) {}

    // GET /api/tasks
    public function index(): JsonResponse
    {
        return response()->json($this->tasks->list());
    }

    // POST /api/tasks
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->tasks->create($request->validated());

        return response()->json($task, 201);
    }

    // GET /api/tasks/{id}
    public function show(int $id): JsonResponse
    {
        return response()->json($this->tasks->find($id));
    }

    // PUT/PATCH /api/tasks/{id}
    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        return response()->json($this->tasks->update($id, $request->validated()));
    }

    // DELETE /api/tasks/{id}
    public function destroy(int $id): JsonResponse
    {
        $this->tasks->delete($id);

        return response()->json(['message' => 'Tarea eliminada correctamente']);
    }
}
