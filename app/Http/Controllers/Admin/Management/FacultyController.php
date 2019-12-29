<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\FacultyFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\User;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(FacultyFilter $filters)
    {
        $faculties = Faculty::orderBy('name')
            ->with('managers', 'media')
            ->withCount('children', 'users')
            ->filter($filters)
            ->safePaginate();

        return view('admin.faculty.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculty.create');
    }

    public function store(Request $request)
    {
        $this->validateFaculty($request);

        $faculty = Faculty::create($request->only([
            'name', 'slug', 'latitude', 'longitude', 'address', 'city', 'code', 'started_at'
        ]));
        $faculty->addMedia($request->logo);

        session_success("<strong>{$faculty->full_name}</strong> fakültesi başarıyla oluşturuldu");

        return redirect()->route('admin.faculty.index');
    }

    public function show(Faculty $faculty)
    {
        return view('admin.faculty.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        $users = $faculty->users()->orderBy('first_name')->get()->pluck('full_name', 'id');

        $managers = $faculty->managers()->pluck('id')->toArray();

        return view('admin.faculty.edit', compact('faculty', 'users', 'managers'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $this->validateFaculty($request, true);

        $faculty->update($request->only([
            'name', 'slug', 'latitude', 'longitude', 'address', 'city', 'code', 'started_at', 'stopped_at'
        ]));
        if ($request->hasFile('logo')) {
            $faculty->clearMediaCollection();
            $faculty->addMedia($request->logo);
        }

        $faculty->managers->each->removeRole('manager');
        User::whereIn('id', $request->users
            ?: [])->get()->each->syncRoles('manager');

        return redirect()->route('admin.faculty.show', $faculty->id);
    }

    public function destroy(Faculty $faculty)
    {
        //
    }

    private function validateFaculty(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'name'      => 'required|max:255', 'slug' => 'required|max:255', 'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric', 'city' => 'required|max:255'
        ]);
    }

}