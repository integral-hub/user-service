<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\UserPreference;
use App\Interfaces\UserInterface;
use App\Models\UserPreferences;
use Illuminate\Support\Facades\DB;

class UserService implements UserInterface
{
    /**
     * Create a new user with preferences inside a database transaction.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data): User {

            // Extract preferences from data
            $preferences= $data['preferences'];
            unset($data['preferences']);

            // Create the user
            $user = User::query()->create($data);

            // Create user preferences
            $user->preference()->create([
                'email' => $preferences['email'] ?? false,
                'push' => $preferences['push'] ?? false,
            ]);

            // Optionally, dispatch an event
            // event(new UserRegistration($user));

            return $user;
        });
    }
}
