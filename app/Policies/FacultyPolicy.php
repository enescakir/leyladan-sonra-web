<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class FacultyPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return $user->hasRole(UserRole::FacultyManager);
    }

    public function view(User $user, Faculty $faculty)
    {
        return $user->hasRole(UserRole::FacultyManager);
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Faculty $faculty)
    {
        return false;
    }

    public function delete(User $user, Faculty $faculty)
    {
        return false;
    }

    public function form(User $user)
    {
        return $user->hasRole(UserRole::FacultyManager);
    }
}