<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $tasks;


    public function __construct(TaskRepositoryInterface $tasks)
    {
        $this->tasks = $tasks;
    }

    // GET /api/tasks
    public function index()
    {
        return response()->json($this->tasks->all());
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string',
            'description' => 'required|string',
            'status'      => 'required|in:pendiente,completada',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = $this->tasks->create($request->all());
        return response()->json($task, 201);
    }

    // GET /api/tasks/{id}
    public function show($id)
    {
        $task = $this->tasks->find($id);
        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }
        return response()->json($task);
    }

    // PUT/PATCH /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = $this->tasks->find($id);
        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'status'      => 'sometimes|required|in:pendiente,completada',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $this->tasks->update($task, $request->all());
        return response()->json($task);
    }

    // DELETE /api/tasks/{id}
    public function destroy($id)
    {
        $task = $this->tasks->find($id);
        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }
        $this->tasks->delete($task);
        return response()->json(['message' => 'Tarea eliminada correctamente']);
    }
}
