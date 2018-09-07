<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Filters\TutorialFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Tutorial;

class TutorialController extends AdminController
{

    public function index(TutorialFilter $filters)
    {
        $tutorials = Tutorial::orderBy('id', 'DESC');
        $tutorials->filter($filters);
        $tutorials = $tutorials->paginate();

        $categories = Tutorial::toCategorySelect('Hepsi');
        return view('admin.tutorial.index', compact('tutorials', 'categories'));
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
        return view('admin.tutorial.edit', compact('tutorial'));
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