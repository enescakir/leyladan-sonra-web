<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\WishCategoryFilter;
use App\Http\Controllers\Controller;
use App\Models\WishCategory;
use Illuminate\Http\Request;

class WishCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(WishCategoryFilter $filters)
    {
        $categories = WishCategory::orderBy('name')->filter($filters)->safePaginate();

        return view('admin.wishCategory.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.wishCategory.create');
    }

    public function store(Request $request)
    {
        $category = WishCategory::create($request->only(['name', 'desc']));

        session_success(__('messages.wishCategory.create', ['name' => $category->name]));

        return redirect()->route('admin.wish-category.index');
    }

    public function edit(WishCategory $wish_category)
    {
        return view('admin.wishCategory.edit', compact('wish_category'));
    }

    public function update(Request $request, WishCategory $wish_category)
    {
        $wish_category->update($request->only(['name', 'desc']));

        session_success(__('messages.wishCategory.create', ['name' => $wish_category->name]));

        return redirect()->route('admin.wish-category.index');
    }

    public function destroy(WishCategory $wish_category)
    {
        $wish_category->delete();
        return api_success($wish_category);
    }
}
