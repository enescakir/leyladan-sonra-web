<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $departments = Department::orderBy('name');

        if ($request->filled('search')) {
            $departments->search($request->search);
        }
        if ($request->filled('download')) {
            Department::download($departments);
        }

        $departments = $departments->paginate($request->per_page ?: 25);

        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $department = Department::create([
          'name' => $request->name,
          'desc' => $request->desc
        ]);
        session_success(__('messages.department.create', ['name' =>  $department->name]));
        return redirect()->route('admin.department.index');
    }

    public function edit(Department $department)
    {
        return view('admin.department.edit', compact(['department']));
    }

    public function update(Request $request, Department $department)
    {
        $department->update($request->all());
        session_success(__('messages.department.update', ['name' =>  $department->name]));
        return redirect()->route('admin.department.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return api_success($department);
    }
}
