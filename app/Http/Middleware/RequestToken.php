<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class RequestToken
{
    /**
     * Handle an incoming request.
     *
     * Checks for a valid Sanctum token in X-Service-Token or falls back
     * to a static token from config/services.php.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get token from X-Service-Token header
        $token = $request->header('X-Service-Token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Missing X-Service-Token header.',
            ], 401);
        }

        // Check if the token matches any Sanctum token
        $sanctumToken = PersonalAccessToken::findToken($token);

        if ($sanctumToken) {
            return $next($request);
        }

        // Fallback to static token
        $staticToken = config('services.api.token');

        if (empty($staticToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Server configuration error: Missing static API token.',
            ], 500);
        }

        if (!hash_equals($staticToken, $token)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid token.',
            ], 401);
        }

        // Token is valid — allow request
        return $next($request);
    }
}
