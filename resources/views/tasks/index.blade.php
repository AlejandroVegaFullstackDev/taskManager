@extends('layout')

@section('content')
<!-- Loader Global (oculto por defecto) -->
<div id="globalLoader" style="display: none;">
  <!-- From Uiverse.io by akshat-patel28 -->
  <div class="loader">
    <span class="loader-text">Loading...</span>
  </div>
</div>

<div class="container-fluid px-4" style="width: 100%;">
    <h1 class="text-center my-4">Gestión de Tareas</h1>
    <div class="table-container shadow-lg rounded" style="width: 100%; height: 100%;">
        <table class="table" id="tasksTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se llenará dinámicamente con JavaScript -->
            </tbody>
        </table>
    </div>
    <button id="createTaskButton" class="btn btn-success btn-lg shadow">
        <i class="bi bi-plus-circle"></i>
        <span class="button-text">Crear Tarea</span>
    </button>
</div>

<!-- Modal para Crear Tarea (equivalente a la vista crear) -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createTaskModalLabel"><i class="bi bi-pencil-square"></i> Crear Tarea</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="createTaskForm" class="shadow p-4 rounded bg-white">
            <div class="mb-3">
                <label for="createTitle" class="form-label fw-bold">Título</label>
                <input type="text" id="createTitle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="createDescription" class="form-label fw-bold">Descripción</label>
                <textarea id="createDescription" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="createStatus" class="form-label fw-bold">Estado</label>
                <select id="createStatus" class="form-select" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="completada">Completada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                <i class="bi bi-save"></i> Guardar
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Editar Tarea (equivalente a la vista editar) -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editTaskModalLabel"><i class="bi bi-pencil-square"></i> Editar Tarea</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="editTaskForm" class="shadow p-4 rounded bg-white">
            <!-- Campo oculto para guardar el id de la tarea -->
            <input type="hidden" id="editTaskId">
            <div class="mb-3">
                <label for="editTitle" class="form-label fw-bold">Título</label>
                <input type="text" id="editTitle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="editDescription" class="form-label fw-bold">Descripción</label>
                <textarea id="editDescription" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="editStatus" class="form-label fw-bold">Estado</label>
                <select id="editStatus" class="form-select" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="completada">Completada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                <i class="bi bi-save"></i> Guardar
            </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
