<?php

namespace App\Policies;

use App\Enums\ProcessType;
use App\Enums\UserRole;
use App\Models\Chat;
use App\Models\Child;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class ChatPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return false;
    }

    public function listFaculty(User $user, Faculty $faculty)
    {
        if ($user->faculty_id != $faculty->id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function listChild(User $user, Child $child)
    {
        if ($user->faculty_id != $child->faculty_id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function view(User $user, Chat $chat)
    {
        if ($user->faculty_id != $chat->faculty_id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function update(User $user, Chat $chat)
    {
        if ($user->faculty_id != $chat->faculty_id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

}
