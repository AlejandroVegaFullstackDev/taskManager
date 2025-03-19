@extends('layout')

@section('content')
<h1>Lista de Tareas</h1>
<a href="/tasks/create" class="btn btn-primary mb-3">Crear Tarea</a>
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

<script>
async function loadTasks() {
    const token = localStorage.getItem('access_token');
    try {
        const response = await fetch('/api/tasks', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        const tasks = await response.json();
        const tbody = document.querySelector('#tasksTable tbody');
        tbody.innerHTML = '';
        tasks.forEach(task => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${task.id}</td>
                <td>${task.title}</td>
                <td>${task.description}</td>
                <td>${task.status}</td>
                <td>
                    <a href="/tasks/${task.id}/edit" class="btn btn-sm btn-warning">Editar</a>
                    <button onclick="deleteTask(${task.id})" class="btn btn-sm btn-danger">Eliminar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error(error);
    }
}

async function deleteTask(id) {
    const token = localStorage.getItem('access_token');
    if (!confirm('¿Estás seguro de eliminar esta tarea?')) return;
    try {
        const response = await fetch(`/api/tasks/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        if (response.ok) {
            loadTasks();
        } else {
            const data = await response.json();
            alert('Error: ' + JSON.stringify(data));
        }
    } catch (error) {
        console.error(error);
    }
}

document.addEventListener('DOMContentLoaded', loadTasks);
</script>
@endsection
