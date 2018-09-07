<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Filters\MaterialFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends AdminController
{
    public function index(MaterialFilter $filters)
    {
        $materials = Material::latest()->with('media');
        $materials->filter($filters);
        $materials = $materials->paginate();

        $categories = Material::toCategorySelect('Hepsi');
        return view('admin.material.index', compact('materials', 'categories'));
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
        $material->addMedia($request->image);
        session_success(__('messages.material.create', ['name' =>  $material->name]));
        return redirect()->route('admin.material.index');
    }

    public function edit(Material $material)
    {
        return view('admin.material.edit', compact('material'));
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
            $material->addMedia($request->image);
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
