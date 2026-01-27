<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch(TokenExpiredException $e) {
            $resp = [
                'success' => false,
                'message' => 'Token has expired.'
            ];
            return response()->json($resp, 401);
        } catch(TokenInvalidException $e) {
            $resp = [
                'success' => false,
                'message' => 'Invalid token.'
            ];
            return response()->json($resp, 401);
        } catch(Exception $e) {
            $resp = [
                'success' => false,
                'message' => 'Unauthenticated.'
            ];
            return response()->json($resp, 401);
        }

        return $next($request);
    }
}
