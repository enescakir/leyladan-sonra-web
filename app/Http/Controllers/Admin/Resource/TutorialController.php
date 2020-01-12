<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Filters\TutorialFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutorial;

class TutorialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(TutorialFilter $filters)
    {
        $this->authorize('list', Tutorial::class);

        $tutorials = Tutorial::filter($filters)->latest()->safePaginate();

        $categories = Tutorial::toCategorySelect('Hepsi');

        return view('admin.tutorial.index', compact('tutorials', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Tutorial::class);

        return view('admin.tutorial.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tutorial::class);

        $this->validateTutorial($request);

        $tutorial = Tutorial::create([
            'name'     => $request->name,
            'link'     => $request->link,
            'category' => $request->category,
        ]);

        session_success(__('messages.tutorial.create', ['name' => $tutorial->name]));

        return redirect()->route('admin.tutorial.index');
    }

    public function edit(Tutorial $tutorial)
    {
        $this->authorize('list', $tutorial);

        return view('admin.tutorial.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $this->authorize('update', $tutorial);

        $this->validateTutorial($request, true);

        $tutorial->update([
            'name'     => $request->name,
            'link'     => $request->link,
            'category' => $request->category,
        ]);

        session_success(__('messages.tutorial.update', ['name' => $tutorial->name]));

        return redirect()->route('admin.tutorial.index');
    }

    public function destroy(Tutorial $tutorial)
    {
        $this->authorize('delete', $tutorial);

        $tutorial->delete();

        return api_success($tutorial);
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