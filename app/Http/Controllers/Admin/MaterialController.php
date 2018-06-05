<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Material;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $materials = Material::orderBy('id', 'DESC')->with('media');
        if ($request->filled('search')) {
            $materials->search($request->search);
        }
        if ($request->filled('category')) {
            $materials->where('category', $request->category);
        }
        $materials = $materials->paginate($request->per_page ?: 25);
        $categories = Material::toCategorySelect('Hepsi');
        return view('admin.material.index', compact(['materials', 'categories']));
    }

    public function create()
    {
        return view('admin.material.create');
    }

    public function store(Request $request)
    {
        $this->validateMaterial($request);
        $material = Material::create([
          'name'     => $request->name,
          'link'     => $request->link,
          'category' => $request->category,
        ]);
        $material->uploadMedia($request->image);
        session_success(__('messages.material.create', ['name' =>  $material->name]));
        return redirect()->route('admin.material.index');
    }

    public function edit(Material $material)
    {
        return view('admin.material.edit', compact(['material']));
    }

    public function update(Request $request, Material $material)
    {
        $this->validateMaterial($request, true);
        $material->update([
            'name'     => $request->name,
            'link'     => $request->link,
            'category' => $request->category,
        ]);
        if ($request->hasFile('image')) {
            $material->clearMediaCollection();
            $material->uploadMedia($request->image);
        }
        session_success(__('messages.material.update', ['name' =>  $material->name]));
        return redirect()->route('admin.material.index');
    }

    public function destroy(Material $material)
    {
        $material->clearMediaCollection();
        $material->delete();
        return $material;
    }

    private function validateMaterial(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
          'name'     => 'required|string|max:255',
          'link'     => 'required|string',
          'category' => 'required|string',
          'image'    => 'image' . ($isUpdate ? '' : '|required'),
      ]);
    }
}
