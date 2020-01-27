<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Material;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class MaterialPolicy
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

    public function update(User $user, Material $material)
    {
        return false;
    }

    public function delete(User $user, Material $material)
    {
        return false;
    }

}
