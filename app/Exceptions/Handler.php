<?php

namespace App\Exception\Http;

use Throwable;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends Exception
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(): void
    {
        //
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->expectsJson()) {

            if ($exception instanceof ValidationException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => __('api.auth.validation_error'),
                    'code' => 400,
                    'errors' => $exception->validator->errors()
                ], 422);
            }

            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Model not found',
                    'code' => 404,
                ], 404);
            }

            if ($exception instanceof AuthenticationException) {
                return $this->unauthenticated($request, $exception);
            }

            if ($exception instanceof AuthorizationException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $exception->getMessage(),
                    'code' => 403,
                ], 403);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => __('api.auth.invalid_route'),
                    'code' => 404,
                ], 404);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => __('api.auth.method_invalid'),
                    'code' => 405,
                ], 405);
            }

            if ($exception instanceof HttpException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $exception->getMessage(),
                    'code' => $exception->getStatusCode(),
                ], $exception->getStatusCode());
            }

            if ($exception instanceof QueryException) {
                $errorCode = $exception->errorInfo[1] ?? null;
                if ($errorCode == 1451) { // Foreign key constraint fail
                    return response()->json([
                        'status' => 'failed',
                        'message' => __('api.auth.related_resource'),
                        'code' => 409,
                    ], 409);
                }
            }

            // Default fallback if no specific handler matched
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage(),
                'code' => 400,
            ], 400);
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'failed',
                'message' => __('api.auth.unauthenticated'),
                'code' => 401,
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}
