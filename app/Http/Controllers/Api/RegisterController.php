<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use Illuminate\Support\Str;
use App\Enums\Message;

class RegisterController extends Controller
{
    /**
     * New user register
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $error = [
                'code' => Message::VALIDATION_FAILED->name,
                'message' => Message::VALIDATION_FAILED->value,
                'detail' => $e->errors()
            ];
            return $this->jsonResponse(422, false, Message::VALIDATION_FAILED->value, null, $error);
        }

        $data['password'] = Hash::make($data['password']);
        $data['public_id'] = (string) Str::ulid();

        User::create($data);

        return $this->jsonResponse(201, true, Message::USER_REGISTERED_SUCCESSFULLY->value);
    }
}
