<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function successResponse($data = [], $message = null, $code = 200)
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = null, $code = 400)
    {
        dd('atejo');
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => null
        ], $code);
    }
}
