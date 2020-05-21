<?php

namespace App\Policies;

use App\Enums\ProcessType;
use App\Enums\UserRole;
use App\Models\Volunteer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class VolunteerPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
            UserRole::Gift,
        ]);
    }

    public function view(User $user, Volunteer $volunteer)
    {
        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function create(User $user)
    {
        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function update(User $user, Volunteer $volunteer)
    {
        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function delete(User $user, Volunteer $volunteer)
    {
        return false;
    }

}
