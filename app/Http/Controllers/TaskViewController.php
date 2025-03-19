<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskViewController extends Controller
{
    // GET /tasks
    public function index()
    {
        // Simplemente retornar la vista, sin pasar datos
        return view('tasks.index');
    }

    // GET /tasks/create
    public function create()
    {
        // Solo retornar la vista create
        return view('tasks.create');
    }

    // GET /tasks/{id}/edit
    public function edit($id)
    {
        // Si deseas pasar el id a la vista (por ejemplo, para usarlo en un fetch)
        // return view('tasks.edit', ['taskId' => $id]);

        // O si no necesitas pasarlo, simplemente:
        return view('tasks.edit');
    }

    // El resto de métodos (show, store, update, destroy) pueden quedar vacíos
    // o eliminarse si no los usarás en vistas.
}
