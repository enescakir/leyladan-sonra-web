<?php

namespace App\Policies;

use App\Enums\ProcessType;
use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;


class PostPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole(UserRole::Admin)) {
            return true;
        }

        if (!$user->isApproved() || $user->hasRole(UserRole::Left)) {
            return false;
        }
    }

    public function listFaculty(User $user, Faculty $faculty)
    {
        if ($user->faculty_id != $faculty->id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Website,
        ]);
    }

    public function listAll(User $user)
    {
        return false;
    }

    public function update(User $user, Post $post)
    {
        if ($user->faculty_id != $post->child->faculty_id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Website,
        ]);
    }

    public function delete(User $user, Post $post)
    {
        if ($user->faculty_id != $post->child->faculty_id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Website,
        ]);
    }

    public function approve(User $user, Post $post)
    {
        if ($user->faculty_id != $post->child->faculty_id) {
            return false;
        }

        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Website,
        ]);
    }
}
