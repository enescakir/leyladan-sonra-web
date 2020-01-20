<?php

namespace App\Policies;

use App\Enums\ProcessType;
use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Child;
use Illuminate\Auth\Access\HandlesAuthorization;


class ChildPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return true;
    }

    public function listFaculty(User $user, Faculty $faculty)
    {
        if ($user->faculty_id != $faculty->id) {
            return false;
        }

        if ($user->hasRole(UserRole::Graduated)) {
            return false;
        }

        return true;
    }

    public function listAll(User $user)
    {
        return $user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::Relation,
        ]);
    }

    public function view(User $user, Child $child)
    {
        if ($user->faculty_id != $child->faculty_id) {
            return false;
        }

        if ($user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::FacultyBoard,
            UserRole::Gift,
            UserRole::Relation,
            UserRole::Website,
        ])) {
            return true;
        }

        return $this->hasUser($child, $user);
    }

    public function create(User $user)
    {
        return !$user->hasRole(UserRole::Graduated);
    }

    public function update(User $user, Child $child)
    {
        if ($user->faculty_id != $child->faculty_id) {
            return false;
        }

        if ($user->hasAnyRole([
            UserRole::FacultyManager,
            UserRole::FacultyBoard,
            UserRole::Website,
        ])) {
            return true;
        }

        return $this->hasUser($child, $user);
    }

    public function process(User $user, Child $child, int $type)
    {
        if ($user->faculty_id != $child->faculty_id) {
            return false;
        }

        if ($type == ProcessType::Created) {
            return $this->create($user);
        }

        if ($type == ProcessType::PostApproved || $type == ProcessType::PostUnapproved) {
            return $user->hasAnyRole([
                UserRole::FacultyManager,
                UserRole::Website,
            ]);
        }

        if ($type == ProcessType::VolunteerFound || $type == ProcessType::VolunteerDecided) {
            return $user->hasAnyRole([
                UserRole::FacultyManager,
                UserRole::FacultyBoard,
                UserRole::Relation,
            ]);
        }

        if (($type == ProcessType::GiftArrived || $type == ProcessType::GiftDelivered) && $user->hasAnyRole([
                UserRole::FacultyManager,
                UserRole::FacultyBoard,
                UserRole::Gift,
            ])) {
            return true;
        }

        if ($type == ProcessType::Reset) {
            return $user->hasAnyRole([
                UserRole::FacultyManager,
                UserRole::FacultyBoard,
            ]);
        }

        if ($type == ProcessType::Deleted) {
            return false;
        }

        if ($type == ProcessType::Visit) {
            return true;
        }

        return $this->hasUser($child, $user);
    }

    public function delete(User $user, Child $child)
    {
        return false;
    }

    private function hasUser(Child $child, User $user)
    {
        return $child->users->where('id', $user->id)->count() > 0;
    }
}
