<?php

namespace App\Http\Controllers\Api;

use App\DTOs\RegisterUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest; // We'll create this next, or use inline validation for speed
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $data = RegisterUserData::fromRequest($request);
        $result = $this->authService->register($data);

        return response()->json($result, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $this->authService->login($credentials);

        return response()->json($result);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}