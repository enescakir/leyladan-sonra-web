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

    public function before($user, $ability)
    {
        if ($user->hasRole(UserRole::Admin)) {
            return true;
        }

        if (!$user->isApproved()) {
            return false;
        }

        if ($user->hasRole(UserRole::Blood)) {
            return true;
        }
    }

    public function list(User $user)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Blood $blood)
    {
        return false;
    }

    public function delete(User $user, Blood $blood)
    {
        return false;
    }

    public function auth(User $user)
    {
        return false;
    }

    public function send(User $user)
    {
        return false;
    }

}
