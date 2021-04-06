<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function successResponse($data = [], $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'success' => true,
            'message' => $message,
            'data' => $data,
            'execution_time' => null,
        ], $code);
    }

    protected function errorResponse($message = null, $code = 400)
    {
        return response()->json([
            'status' => 'Error',
            'success' => true,
            'error' => $message,
            'message' => $message,
            'data' => null,
            'execution_time' => null,
        ], $code);
    }
}
