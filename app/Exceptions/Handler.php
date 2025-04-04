<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return BaseResponse::error('Internal Server Error', 500, $exception->getMessage());
        }

        // otherwise, still call parent::render
        $response = parent::render($request, $exception);
        // If respons not JSON, convert to JSON
        if (!$response instanceof JsonResponse) {
            return BaseResponse::error('An error occurred', $response->getStatusCode(), $exception->getMessage());
        }

        return $response;
    }
}
