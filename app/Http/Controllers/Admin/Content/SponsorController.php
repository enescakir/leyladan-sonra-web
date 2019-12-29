<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\SponsorFilter;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(SponsorFilter $filters)
    {
        $sponsors = Sponsor::orderBy('order', 'DESC')->with('media')->filter($filters)->safePaginate();

        return view('admin.sponsor.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsor.create');
    }

    public function store(Request $request)
    {
        $this->validateSponsor($request);
        $sponsor = Sponsor::create($request->only(['name', 'link', 'order']));
        $sponsor->addMedia($request->logo);

        session_success(__('messages.sponsor.create', ['name' => $sponsor->name]));

        return redirect()->route('admin.sponsor.index');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsor.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $this->validateSponsor($request, true);
        $sponsor->update($request->only(['name', 'link', 'order']));
        if ($request->hasFile('logo')) {
            $sponsor->clearMediaCollection();
            $sponsor->addMedia($request->logo);
        }

        session_success(__('messages.sponsor.update', ['name' => $sponsor->name]));

        return redirect()->route('admin.sponsor.index');
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return api_success($sponsor);
    }

    private function validateSponsor(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'name'  => 'required|string|max:255',
            'link'  => 'required|string',
            'order' => 'required|integer',
            'logo'  => 'image' . ($isUpdate ? '' : '|required'),
        ]);
    }
}
