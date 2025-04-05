<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class BaseResponse
{
    public static function success($data = null, $message = 'Success', $status = 200): JsonResponse
    {
        $responseData = [
            'status' => $status,
            'message' => $message
        ];
        if ($data) {
            $responseData['data'] = $data;
        }
        return response()->json($responseData, $status);
    }

    public static function error($message = 'Error', $status = 400, $errorKey  = 'unknown_error', $errors = null): JsonResponse
    {
        $responseData = [
            'status' => $status,
            'message' => $message,
            'error_key' => $errorKey,
        ];

        if ($errors) {
            $responseData['errors'] = $errors;
        }
        return response()->json($responseData, $status);
    }
    public static function paginated($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'limit' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_page' => $data->lastPage(),
            ],
        ], $status);
    }
}
