<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    function authenticate(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'username' => 'required|email',
                'password' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->jsonResponse(422, false, "Validation failed.", null, $e->errors());
        }

        $email = $data['username'];
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            return $this->jsonResponse(400, false, "Login failed.", null, []);
        }

        // verifying password
        if ( ! Hash::check($data['password'], $user->password)) {
            return $this->jsonResponse(401, false, "Wrong username or password.");
        }

        // revoke old sanctum token
        $user->tokens()->delete();
        
        $token = $user->createToken(env('SANCTUM_TOKEN_NAME'));
        
        return $this->jsonResponse(200, true, "Logged in successfully.", [
            'token' => $token->plainTextToken
        ]);
    }
}
