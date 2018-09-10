<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\UserFilter;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;

class FacultyUserController extends AdminController
{

    public function index(UserFilter $filters, Faculty $faculty)
    {
        $users = $faculty->users()->latest()->with(['roles']);
        $users->filter($filters);
        $users = $this->paginate($users);

        $roles = Role::toSelect('Yeni Görev');

        return view('admin.faculty.user.index', compact('users', 'faculty', 'roles'));
    }

    public function edit(Faculty $faculty, User $user)
    {
        $roles = Role::toSelect('Görev seçiniz');

        return view('admin.faculty.user.edit', compact('user', 'faculty', 'roles'));
    }

}
