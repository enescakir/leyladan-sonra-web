<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\UserFilter;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Faculty;
use App\Models\User;

class FacultyUserController extends AdminController
{
    protected $faculty;

    public function __construct(Faculty $faculty)
    {
        $this->faculty = $faculty;
    }

    public function index(UserFilter $filters)
    {
        $users = $this->faculty->users()->latest()->with(['roles', 'faculty']);

        $users->filter($filters);

        $users = $this->paginate($users);

        return view('admin.user.faculty', compact('users', 'faculty'));
    }
}
