@extends('layout')

@section('content')
<h1>Crear Tarea</h1>
<form id="createTaskForm">
    <div class="form-group">
        <label for="title">Título</label>
        <input type="text" id="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Descripción</label>
        <textarea id="description" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="status">Estado</label>
        <select id="status" class="form-control" required>
            <option value="pendiente">Pendiente</option>
            <option value="completada">Completada</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

<script>
document.getElementById('createTaskForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const status = document.getElementById('status').value;
    // Obtener el token JWT almacenado (debe haberse guardado tras el login)
    const token = localStorage.getItem('access_token');

    try {
        const response = await fetch('/api/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ title, description, status })
        });
        if (response.ok) {
            // Redirige a la lista de tareas al crear correctamente
            window.location.href = '/tasks';
        } else {
            const data = await response.json();
            alert('Error: ' + JSON.stringify(data));
        }
    } catch (error) {
        console.error(error);
        alert('Error en la conexión');
    }
});
</script>
@endsection
