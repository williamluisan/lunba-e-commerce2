<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    private $_sanctum_is_enabled = false;
    private $_jwt_is_enabled = false;

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

        /* sanctum implementation */
        $this->_sanctum_is_enabled = env('SANCTUM_IS_ENABLED');
        if ($this->_sanctum_is_enabled) {
            // revoke old sanctum token
            $user->tokens()->delete();
            
            $token = $user->createToken(env('SANCTUM_TOKEN_NAME'));

            $tokenPlainText = $token->plainTextToken;
        }
        /* // */

        /* JWT implementation */
        $this->_jwt_is_enabled = env('JWT_IS_ENABLED');
        if ($this->_jwt_is_enabled) {
            try {
                $token = JWTAuth::fromUser($user);
                $tokenPlainText = $token;
            } catch (JWTException $e) {
                return $this->jsonResponse(500, false, "Failed to create token.");
            }
        }
        /* // */
        
        return $this->jsonResponse(200, true, "Logged in successfully.", [
            'token' => $tokenPlainText
        ]);
    }
}
