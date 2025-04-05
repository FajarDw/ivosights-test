<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Http\Responses\BaseResponse;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    {   // Validasi input
        if ($exception instanceof ValidationException) {
            return BaseResponse::error(
                'Validation Error',
                422,
                'validation_error',
                $exception->errors()
            );
        }
        // URL tidak ditemukan
        if ($exception instanceof NotFoundHttpException) {
            return BaseResponse::error(
                'Route Not Found',
                404,
                'not_found'
            );
        }

        // Data tidak ditemukan
        if ($exception instanceof RecordsNotFoundException) {
            return BaseResponse::error(
                'Data Not Found',
                404,
                'data_not_found'
            );
        }

        if ($request->expectsJson()) {
            return BaseResponse::error(
                $exception->getMessage() ?: 'Internal Server Error',
                method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500,
                'server_error'
            );
        }

        // otherwise, still call parent::render
        return parent::render($request, $exception);
    }
}
