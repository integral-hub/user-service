<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\Auth\LoginInterface;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * User Login
     *
     * @group Authentication
     * @name Login
     *
     * This endpoint handles user login. It returns a user object and authentication token.
     *
     * @bodyParam email string required The email address of the user. Example: user@example.com
     * @bodyParam password string required The password for the user account. Example: secretpassword123
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com"
     *   },
     *   "token": "your-auth-token"
     * }
     *
     * @response 401 {
     *   "success": false,
     *   "error": "Invalid credentials"
     * }
     *
     * @param LoginRequest $request
     * @param LoginInterface $loginInterface
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request, LoginInterface $loginInterface): JsonResponse
    {
        $response = $loginInterface->attempt($request->validated());
        
        if ($response->has('error')) {
            return response()->json([
                'success' => false,
                'error' => $response->get('error')
            ], 401);
        }

        $user = $response->get('user');
        $token = $response->get('token')['token'] ?? null;

        if (!$token) {
            return response()->json([
                'success' => false,
                'error' => 'Token generation failed'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => $user,
            'token' => $token
        ], 200);
    }
}
