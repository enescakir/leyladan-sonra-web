<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tutorial;

class TutorialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tutorials = Tutorial::orderBy('id', 'DESC');
        if ($request->filled('search')) {
            $tutorials->search($request->search);
        }
        if ($request->filled('category')) {
            $tutorials->where('category', $request->category);
        }
        $tutorials = $tutorials->paginate($request->per_page ?: 25);
        $categories = Tutorial::toCategorySelect('Hepsi');
        return view('admin.tutorial.index', compact(['tutorials', 'categories']));
    }

    public function create()
    {
        return view('admin.tutorial.create');
    }

    public function store(Request $request)
    {
        $this->validateTutorial($request);
        $tutorial = Tutorial::create([
          'name'     => $request->name,
          'link'     => $request->link,
          'category' => $request->category,
        ]);
        session_success(__('messages.tutorial.create', ['name' =>  $tutorial->name]));
        return redirect()->route('admin.tutorial.index');
    }

    public function edit(Tutorial $tutorial)
    {
        return view('admin.tutorial.edit', compact(['tutorial']));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $this->validateTutorial($request, true);
        $tutorial->update([
            'name'     => $request->name,
            'link'     => $request->link,
            'category' => $request->category,
        ]);
        session_success(__('messages.tutorial.update', ['name' =>  $tutorial->name]));
        return redirect()->route('admin.tutorial.index');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();
        return $tutorial;
    }

    private function validateTutorial(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
          'name'     => 'required|string|max:255',
          'link'     => 'required|string',
          'category' => 'required|string'
      ]);
    }
}
