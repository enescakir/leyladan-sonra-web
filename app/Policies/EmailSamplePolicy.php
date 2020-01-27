<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\EmailSample;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class EmailSamplePolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, EmailSample $emailSample)
    {
        return false;
    }

    public function delete(User $user, EmailSample $emailSample)
    {
        return false;
    }

}
