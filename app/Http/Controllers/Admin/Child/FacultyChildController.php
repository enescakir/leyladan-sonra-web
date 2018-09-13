<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Filters\ChildFilter;

class FacultyChildController extends AdminController
{
    public function index(ChildFilter $filters, Faculty $faculty)
    {
        $children = $faculty->children()->with('users')->latest();
        $children->filter($filters);
        $children = $this->paginate($children);

        return view('admin.faculty.child.index', compact('faculty', 'children'));
    }
}
