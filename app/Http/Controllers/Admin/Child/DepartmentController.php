<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\DepartmentFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(DepartmentFilter $filters)
    {
        $this->authorize('list', Department::class);

        $departments = Department::filter($filters)->orderBy('name')->safePaginate();

        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        $this->authorize('create', Department::class);

        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Department::class);

        $department = Department::create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);

        session_success(__('messages.department.create', ['name' => $department->name]));

        return redirect()->route('admin.department.index');
    }

    public function edit(Department $department)
    {
        $this->authorize('update', $department);

        return view('admin.department.edit', compact(['department']));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('update', $department);

        $department->update($request->all());

        session_success(__('messages.department.update', ['name' => $department->name]));

        return redirect()->route('admin.department.index');
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->delete();

        return api_success($department);
    }
}
