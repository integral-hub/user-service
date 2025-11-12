<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    public function __construct(
        private readonly UserInterface $userService
    ){}

    /**
     * Create a new user with preferences.
     *
     */
    public function store(UserRequest $request): JsonResponse
    {

        $user = $this->userService->create($request->validated());

        // Load preferences for the response
        $user->load('preference');

        return response()->json([
            'success' => true,
            'user' => $user,
        ], 201);
    }

    /**
     * Get a single user with preferences.
     *
     */
    public function show(User $user): JsonResponse
    {
        $user->loadMissing('preference');

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    /**
     * Get all users with preferences.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $users = User::with('preference')->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }
}
