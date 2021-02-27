<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     */
    public function render($request, Throwable $exception)
    {
        return ResponseHandler::response($exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (AuthenticationException $e, $request) {
                return response()->json(['message' => 'unauthenticated'], 401);
        });


        $this->reportable(function (ValidationException $e, $request) {
                return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 400);
        });

        $this->renderable(function (Throwable $e, $request) {
                return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTrace()], 404);
        });
    }
}
