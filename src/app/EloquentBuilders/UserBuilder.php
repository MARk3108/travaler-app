<?php

namespace App\EloquentBuilders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
