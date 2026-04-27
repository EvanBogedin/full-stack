<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::query()->where('name', $validated['name'])->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                return response()->json(false, 200);
            }

            $token = $user->createToken('api-login-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'message' => 'Login successful!',
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
