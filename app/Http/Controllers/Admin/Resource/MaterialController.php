<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Filters\MaterialFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index(MaterialFilter $filters)
    {
        $this->authorize('list', Material::class);

        $materials = Material::filter($filters)->with('media')->latest()->safePaginate();

        $categories = Material::toCategorySelect('Hepsi');

        return view('admin.material.index', compact('materials', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Material::class);

        return view('admin.material.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Material::class);

        $this->validateMaterial($request);

        $material = Material::create($request->only(['name', 'link', 'category']));
        $material->addMedia($request->image);

        session_success(__('messages.material.create', ['name' => $material->name]));

        return redirect()->route('admin.material.index');
    }

    public function edit(Material $material)
    {
        $this->authorize('update', $material);

        return view('admin.material.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $this->authorize('update', $material);

        $this->validateMaterial($request, true);

        $material->update($request->only(['name', 'link', 'category']));
        if ($request->hasFile('image')) {
            $material->clearMediaCollection();
            $material->addMedia($request->image);
        }

        session_success(__('messages.material.update', ['name' => $material->name]));

        return redirect()->route('admin.material.index');
    }

    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);

        $material->delete();

        return api_success($material);
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
