document.addEventListener('DOMContentLoaded', () => {
    // Funciones para mostrar y ocultar el loader global
    window.showLoader = function() {
        document.getElementById("globalLoader").style.display = "flex";
    }

    window.hideLoader = function() {
        document.getElementById("globalLoader").style.display = "none";
    }

    /**
     * Si recibimos un 401, llamamos al endpoint de logout
     * y redireccionamos al login.
     */
    window.handleUnauthorized = async function() {
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        } catch (error) {
            console.error('Error al intentar hacer logout:', error);
        } finally {
            // Redirigir a la página de login
            window.location.href = '/login';
        }
    }

    window.loadTasks = async function() {
        const token = localStorage.getItem('access_token');
        showLoader();
        try {
            const response = await fetch('/api/tasks', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.status === 401) {
                await handleUnauthorized();
                return;
            }
            if (!response.ok) {
                console.error('Error al cargar las tareas:', response.statusText);
                Swal.fire('Error', 'Error al cargar las tareas', 'error');
                return;
            }

            const tasks = await response.json();
            const tbody = document.querySelector('#tasksTable tbody');
            tbody.innerHTML = '';
            tasks.forEach(task => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.title}</td>
                    <td>${task.description}</td>
                    <td>
                        <span class="badge ${task.status === 'completada' ? 'bg-success' : 'bg-warning'}">
                            ${task.status === 'completada' ? 'Completada' : 'Pendiente'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-2" onclick="openEditModal(${task.id})">
                            <i class="bi bi-pencil-square"></i> Editar
                        </button>
                        <button onclick="deleteTask(${task.id})" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        } catch (error) {
            console.error('Error al cargar las tareas:', error);
            Swal.fire('Error', 'Error al cargar las tareas', 'error');
        } finally {
            hideLoader();
        }
    }

    window.deleteTask = async function(id) {
        const token = localStorage.getItem('access_token');
        Swal.fire({
            title: '¿Estás seguro de eliminar esta tarea?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                showLoader();
                const deleteButton = document.querySelector(`button[onclick="deleteTask(${id})"]`);
                deleteButton.disabled = true;
                try {
                    const response = await fetch(`/api/tasks/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    if (response.status === 401) {
                        await handleUnauthorized();
                        return;
                    }
                    if (response.ok) {
                        Swal.fire('Eliminado', 'La tarea ha sido eliminada.', 'success');
                        loadTasks();
                    } else {
                        const data = await response.json();
                        Swal.fire('Error', JSON.stringify(data), 'error');
                    }
                } catch (error) {
                    console.error('Error al eliminar la tarea:', error);
                    Swal.fire('Error', 'Error en la conexión', 'error');
                } finally {
                    hideLoader();
                    deleteButton.disabled = false;
                }
            }
        });
    }

    // Al hacer clic en "Crear Tarea" se abre el modal de creación
    document.getElementById('createTaskButton').addEventListener('click', () => {
        const createModal = new bootstrap.Modal(document.getElementById('createTaskModal'));
        createModal.show();
    });

    // Envío del formulario de creación
    document.getElementById('createTaskForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const createButton = document.querySelector('#createTaskForm button[type="submit"]');
        createButton.disabled = true;
        const title = document.getElementById('createTitle').value;
        const description = document.getElementById('createDescription').value;
        const status = document.getElementById('createStatus').value;
        const token = localStorage.getItem('access_token');
        showLoader();
        try {
            const response = await fetch('/api/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ title, description, status })
            });

            if (response.status === 401) {
                await handleUnauthorized();
                return;
            }
            if (response.ok) {
                
                const createModalEl = document.getElementById('createTaskModal');
                const modalInstance = bootstrap.Modal.getInstance(createModalEl);
                modalInstance.hide();
                Swal.fire('Éxito', 'La tarea fue creada correctamente.', 'success');
                loadTasks();
                document.getElementById('createTitle').value = '';
                document.getElementById('createDescription').value = '';
            } else {
                const data = await response.json();
                Swal.fire('Error', JSON.stringify(data), 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Error en la conexión', 'error');
        } finally {
            hideLoader();
            createButton.disabled = false;
        }
    });

    // Envío del formulario de edición
    document.getElementById('editTaskForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const editButton = document.querySelector('#editTaskForm button[type="submit"]');
        editButton.disabled = true;
        const title = document.getElementById('editTitle').value;
        const description = document.getElementById('editDescription').value;
        const status = document.getElementById('editStatus').value;
        const token = localStorage.getItem('access_token');
        const taskId = document.getElementById('editTaskId').value;
        showLoader();
        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ title, description, status })
            });

            if (response.status === 401) {
                await handleUnauthorized();
                return;
            }
            if (response.ok) {
                const editModalEl = document.getElementById('editTaskModal');
                const modalInstance = bootstrap.Modal.getInstance(editModalEl);
                modalInstance.hide();
                Swal.fire('Éxito', 'La tarea fue actualizada correctamente.', 'success');
                loadTasks();
            } else {
                const data = await response.json();
                Swal.fire('Error', JSON.stringify(data), 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Error en la conexión', 'error');
        } finally {
            hideLoader();
            editButton.disabled = false;
        }
    });

    /**
     * Función para abrir el modal de edición y cargar los datos de la tarea
     */
    window.openEditModal = async function(taskId) {
        const token = localStorage.getItem('access_token');
        showLoader();
        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            if (response.status === 401) {
                await handleUnauthorized();
                return;
            }
            if (!response.ok) {
                throw new Error('Error al obtener la tarea');
            }

            const task = await response.json();
            document.getElementById('editTaskId').value = task.id;
            document.getElementById('editTitle').value = task.title;
            document.getElementById('editDescription').value = task.description;
            document.getElementById('editStatus').value = task.status;

            // Inicializa y muestra el modal de edición
            const editModalEl = document.getElementById('editTaskModal');
            const editModal = new bootstrap.Modal(editModalEl);
            editModal.show();
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Error al cargar la tarea', 'error');
        } finally {
            hideLoader();
        }
    }

    // Cargar tareas al cargar la página
    loadTasks();
});
