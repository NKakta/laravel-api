<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($login)) {
            return $this->errorResponse('Auth failed', 401);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return $this->successResponse([
            'user' => Auth::user()->toArray(),
            'accessToken' => $accessToken
        ]);
    }
}
