<?php

namespace App\Policies;

use App\Enums\ProcessType;
use App\Enums\UserRole;
use App\Models\Blood;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Child;
use Illuminate\Auth\Access\HandlesAuthorization;


class BloodPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return $user->hasRole(UserRole::Blood);
    }

    public function create(User $user)
    {
        return $user->hasRole(UserRole::Blood);
    }

    public function update(User $user, Blood $blood)
    {
        return $user->hasRole(UserRole::Blood);
    }

    public function delete(User $user, Blood $blood)
    {
        return $user->hasRole(UserRole::Blood);
    }

    public function auth(User $user)
    {
        return $user->hasRole(UserRole::Blood);
    }

    public function send(User $user)
    {
        return $user->hasRole(UserRole::Blood);
    }

}
