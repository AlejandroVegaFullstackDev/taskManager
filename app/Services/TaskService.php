<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Capa de aplicación: orquesta la lógica de negocio de las tareas y aísla a los
 * controladores de la persistencia. Depende de la interfaz del repositorio
 * (no de su implementación), siguiendo la inversión de dependencias.
 */
class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $tasks,
    ) {}

    public function list(): Collection
    {
        return $this->tasks->all();
    }

    public function create(array $data): Task
    {
        return $this->tasks->create($data);
    }

    /**
     * @throws TaskNotFoundException si la tarea no existe.
     */
    public function find(int $id): Task
    {
        $task = $this->tasks->find($id);

        if (! $task) {
            throw new TaskNotFoundException();
        }

        return $task;
    }

    /**
     * @throws TaskNotFoundException
     */
    public function update(int $id, array $data): Task
    {
        $task = $this->find($id);
        $this->tasks->update($task, $data);

        return $task->refresh();
    }

    /**
     * @throws TaskNotFoundException
     */
    public function delete(int $id): void
    {
        $task = $this->find($id);
        $this->tasks->delete($task);
    }
}
