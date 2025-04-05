<?php

namespace App\Http\Middleware;

use App\Http\Responses\BaseResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');
        $validApiKey = config('app.api_key');

        if (!$apiKey || $apiKey !== $validApiKey) {
            return BaseResponse::error('Unauthorized. Invalid API Key', 401, 'unauthorized');
            // return response()->json(['message' => 'Unauthorized. Invalid API Key'], 401);
        }

        return $next($request);
    }
}
