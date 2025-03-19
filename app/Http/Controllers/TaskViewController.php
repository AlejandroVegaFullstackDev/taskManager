<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskViewController extends Controller
{
    // GET /tasks
    public function index()
    {
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
        return view('tasks.edit', ['taskId' => $id]);
    }
}
