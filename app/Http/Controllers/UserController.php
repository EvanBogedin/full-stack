<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    public function deleteUser(int $id): JsonResponse
    {
        User::query()->whereKey($id)->delete();

        return response()->json(['message' => "User with ID {$id} has been deleted"]);
    }
}
