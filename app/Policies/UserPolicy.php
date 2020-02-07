<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

    public function listFaculty(User $user, Faculty $faculty)
    {
        if ($user->faculty_id != $faculty->id) {
            return false;
        }

        return $user->hasRole(UserRole::FacultyManager);
    }

    public function listAll(User $user)
    {
        return false;
    }

    public function view(User $user, User $u)
    {
        if ($user->faculty_id != $u->faculty_id) {
            return false;
        }

        return $user->hasRole(UserRole::FacultyManager);
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, User $u)
    {
        if ($user->faculty_id != $u->faculty_id) {
            return false;
        }

        return $user->hasRole(UserRole::FacultyManager);
    }

    public function delete(User $user, User $u)
    {
        return false;
    }

    public function approve(User $user, User $u)
    {
        if ($user->faculty_id != $u->faculty_id) {
            return false;
        }

        return $user->hasRole(UserRole::FacultyManager);
    }

    public function sendFaculty(User $user, Faculty $faculty)
    {
        if ($user->faculty_id != $faculty->id) {
            return false;
        }

        return $user->hasRole(UserRole::FacultyManager);
    }
}
