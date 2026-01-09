<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class User extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $data['password'] = bcrypt($data['password']);

        return response()->json($data, 201);
    }

    public function edit(Request $request) 
    {

    }

    public function delete(Request $request) 
    {
        
    }
}
