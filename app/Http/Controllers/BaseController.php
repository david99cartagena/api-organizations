<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected function success($data = null, string $message = 'OK', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error(string $message = 'Error', int $code = 500): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message
        ], $code);
    }

    protected function unauthorized(string $message = 'No autorizado'): JsonResponse
    {
        return $this->error($message, 401);
    }

    protected function notFound(string $message = 'Recurso no encontrado'): JsonResponse
    {
        return $this->error($message, 404);
    }

    protected function validationError($errors, string $message = 'Error de validación'): JsonResponse
    {
        return response()->json([
            'status' => 422,
            'message' => $message,
            'errors' => $errors
        ], 422);
    }
}
