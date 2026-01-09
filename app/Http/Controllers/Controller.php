<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
abstract class Controller
{
    function jsonResponse(
        int $status,
        bool $success, 
        string $message = '', 
        mixed $data = null, 
        array $errors = []): JsonResponse {
        $resp = [
            'success' => $success,
            'message' => $message
        ];
        if ( ! empty($data)) {
            $resp['data'] = $data;
        }
        if ( ! empty($errors)) {
            $resp['errors'] = $errors;
        }

        return response()->json($resp, $status);
    }
}