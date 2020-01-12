<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class TutorialPolicy
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
    }

    public function list(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Tutorial $tutorial)
    {
        return false;
    }

    public function delete(User $user, Tutorial $tutorial)
    {
        return false;
    }

}
