<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;

class FacultyUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(UserFilter $filters, Faculty $faculty)
    {
        $this->authorize('listFaculty', [User::class, $faculty]);

        $users = $faculty->users()->filter($filters)->with(['roles'])->latest()->safePaginate();

        $roles = Role::toSelect('Yeni Görev');

        return view('admin.faculty.user.index', compact('users', 'faculty', 'roles'));
    }

    public function edit(Faculty $faculty, User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::toSelect('Görev seçiniz');

        return view('admin.faculty.user.edit', compact('user', 'faculty', 'roles'));
    }

}
