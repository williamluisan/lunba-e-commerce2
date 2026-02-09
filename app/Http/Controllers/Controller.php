<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
abstract class Controller
{
    function jsonResponse(
        int $status,
        bool $success, 
        string $message = '', 
        mixed $data = null, 
        array $error = []): JsonResponse {

        // resolve first if the data is laravel resource
        if ($data instanceof JsonResource OR $data instanceof ResourceCollection) {
            $data = $data->response()->getData(true);
        }

        $resp = [
            'success' => $success,
            'message' => $message
        ];
        if ( ! empty($data)) {
            $resp['data'] = $data;
        }
        if ( ! empty($error)) {
            $resp['error'] = [
                'code' => $error['code'] ?? NULL,
                'message' => $error['message'] ?? NULL,
                'details' => $error['detail'] ?? NULL
            ];
        }

        return response()->json($resp, $status);
    }
}