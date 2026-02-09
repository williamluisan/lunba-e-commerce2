<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Enums\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $_sanctum_is_enabled = false;
    private $_jwt_is_enabled = false;

    private function _respondWithToken($token): array {
        return [
            'access_token' => $token,
            'token_type' => env('JWT_TOKEN_TYPE'),
            'expires_in' => JWTAuth::factory()->getTTL() * 60, // in seconds
        ];
    }

    function authenticate(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'username' => 'required|email',
                'password' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $error = [
                'code' => Message::VALIDATION_FAILED->name,
                'message' => Message::VALIDATION_FAILED->value,
                'detail' => $e->errors()
            ];
            return $this->jsonResponse(422, false, Message::VALIDATION_FAILED->value, null, $error);
        }

        $email = $data['username'];
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            return $this->jsonResponse(400, false, Message::WRONG_USERNAME_OR_PASSWORD->value, null, []);
        }

        // verifying password
        if ( ! Hash::check($data['password'], $user->password)) {
            return $this->jsonResponse(401, false, Message::WRONG_USERNAME_OR_PASSWORD->value);
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
                return $this->jsonResponse(500, false, Message::FAILED_TO_CREATE_TOKEN->value);
            }
        }
        /* // */
        
        return $this->jsonResponse(200, true, Message::LOGIN_SUCCESS->value, $this->_respondWithToken($token));
    }

    function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return $this->jsonResponse(500, false, Message::LOGOUT_FAILED->value);
        }

        return $this->jsonResponse(200, true, Message::LOGOUT_SUCCESS->value);
    }

    function refresh_token(): JsonResponse 
    {
        try {
            $token = JWTAuth::parseToken()->refresh();
        } catch (TokenExpiredException $e) {
            return $this->jsonResponse(401, false, Message::TOKEN_CANNOT_BE_REFRESHED->value);
        } catch (JWTException $e) {
            return $this->jsonResponse(500, false, Message::FAILED_TO_REFRESH_TOKEN->value);
        }

        return $this->jsonResponse(200, true, Message::TOKEN_REFRESH_SUCCESS->value, $this->_respondWithToken($token));
    }
}
