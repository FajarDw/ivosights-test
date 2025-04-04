<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class BaseResponse
{
    public static function success($data = null, $message = 'Success', $status = 200): JsonResponse
    {
        if ($data) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $status);
        } else {
            return response()->json([
                'status' => $status,
                'message' => $message
            ], $status);
        }
    }

    public static function error($message = 'Error', $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
