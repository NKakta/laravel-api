<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $data['password'] = Hash::make($request['password']);
        $data['remember_token'] = Str::random(10);

        /** @var User $user */
        $user = User::create($data);

        $token = $user->createToken('authToken')->accessToken;

        return $this->successResponse([
            'user' => $user,
            'accessToken' => $token
        ]);
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return $this->errorResponse('Unauthenticated.', 400);
        }

        $token = $request->user()->token();
        $token->revoke();
        return $this->successResponse([], 'You have been successfully logged out!');
    }
}
