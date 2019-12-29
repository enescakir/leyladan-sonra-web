<?php

namespace App\Http\Controllers\Admin\Blood;

use App\Filters\BloodFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blood;

class BloodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BloodFilter $filters)
    {
        $bloods = Blood::latest()->filter($filters)->safePaginate();

        return view('admin.blood.index', compact('bloods'));
    }

    public function create()
    {
        return view('admin.blood.create');
    }

    public function store(Request $request)
    {
        $request['mobile'] = make_mobile($request->mobile);
        $this->validateBlood($request);
        $blood = Blood::create($request->only(['mobile', 'city', 'blood_type', 'rh']));

        session_success(__('messages.blood.create', ['mobile' => $blood->mobile]));

        return redirect()->route('admin.blood.index');
    }

    public function edit(Blood $blood)
    {
        return view('admin.blood.edit', compact('blood'));
    }

    public function update(Request $request, Blood $blood)
    {
        $request['mobile'] = make_mobile($request->mobile);
        $this->validateBlood($request, true);
        $blood->update($request->only(['mobile', 'city', 'blood_type', 'rh']));

        session_success(__('messages.blood.update', ['mobile' => $blood->mobile]));

        return redirect()->route('admin.blood.index');
    }

    public function destroy(Blood $blood)
    {
        $blood->delete();

        return api_success();
    }

    private function validateBlood(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'mobile'     => 'required|max:255' . ($isUpdate
                    ? ''
                    : '|unique:bloods'),
            'city'       => 'required|string|max:255',
            'blood_type' => 'required|string|max:255',
            'rh'         => 'required|string|max:255',
        ]);
    }
}
