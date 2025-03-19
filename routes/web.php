<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskViewController;


Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::resource('tasks', TaskViewController::class);
