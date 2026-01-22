<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * New user register
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['public_id'] = (string) Str::ulid();

        User::create($data);

        return $this->jsonResponse(201, true, 'User registered successfully');
    }
}
