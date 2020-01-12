<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class DiagnosisPolicy
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

    public function update(User $user, Diagnosis $diagnosi)
    {
        return false;
    }

    public function delete(User $user, Diagnosis $diagnosi)
    {
        return false;
    }

}
