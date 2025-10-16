<?php

namespace App\Helper;

class ApiResponse
{
    public function notFound(string $message = 'Recurso no encontrado')
    {
        return response()->json([
            'message' => $message
        ], 404);
    }

    public function serverError(\Throwable $e)
    {
        return response()->json([
            'error' => 'Error interno del servidor',
            'exception_message' => $e->getMessage(),
            'archivo' => $e->getFile(),
            'linea' => $e->getLine(),
        ], 500);
    }
}