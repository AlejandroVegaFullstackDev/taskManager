<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskNotFoundException extends Exception
{
    /**
     * Renderiza la excepción como una respuesta JSON 404.
     * Laravel la captura automáticamente, manteniendo el controlador delgado.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(['error' => 'Tarea no encontrada'], 404);
    }
}
