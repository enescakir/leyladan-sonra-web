<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Filters\ChildFilter;

class FacultyChildController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ChildFilter $filters, Faculty $faculty)
    {
        $children = $faculty->children()->with('users')->latest()->filter($filters)->safePaginate();

        return view('admin.faculty.child.index', compact('faculty', 'children'));
    }
}