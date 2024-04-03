<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Laravel\Passport\Exceptions\AuthenticationException;

class AuthController extends Controller
{
    /**
     * Register New User.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $token = $user->createToken('Access Token')->accessToken;

        return Response::success(['user' => $user, 'token' => $token], 'User created successfully', 201);
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            Response::fail(new AuthenticationException(), 'Incorrect credentials please try again', 401);
        }
        $token = Auth::user()->createToken('Access Token')->accessToken;

        return Response::success(['user' => Auth::user(), 'token' => $token], 'Logged in successfully', 201);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();
        return Response::success([], 'Logged out successfully', 200);
    }
}
