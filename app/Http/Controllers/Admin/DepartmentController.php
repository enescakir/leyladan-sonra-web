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

  public function index()
  {
    $departments = Department::orderBy('name')->get();
    $departments = $departments->chunk(3);
    return view('admin.department.index', compact('departments'));
  }

  public function store(Request $request)
  {
    $department = Department::create([
      'name' => $request->name,
      'desc' => $request->desc
    ]);
    session_success(__('messages.department.create', ['name' =>  $department->name]));
    if ($request->ajax()) {
      return $department;
    }
    return redirect()->route('admin.department.index');
  }

  public function update(Request $request, Department $department)
  {
    $department->update($request->all());
    session_success(__('messages.department.update', ['name' =>  $department->name]));
    if ($request->ajax()) {
      return $department;
    }
    return redirect()->route('admin.department.index');
  }

  public function destroy(Department $department)
  {
    $department->delete();
    return $department;
  }
}
