<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUsers()
    {
        return User::get();
    }

    public function deleteUser($userId): bool
    {
        $user = User::find($userId);

        if ($user) {
            $user->delete();

            return true;
        }

        return false;
    }
}
