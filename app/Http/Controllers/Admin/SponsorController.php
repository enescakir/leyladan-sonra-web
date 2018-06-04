<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sponsors = Sponsor::orderBy('order', 'DESC')->with('media');
        if ($request->filled('search')) {
            $sponsors->search($request->search);
        }
        if ($request->filled('download')) {
            Sponsor::download($sponsors);
        }
        $sponsors = $sponsors->paginate($request->per_page ?: 25);
        return view('admin.sponsor.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsor.create');
    }

    public function store(Request $request)
    {
        $this->validateSponsor($request);
        $sponsor = Sponsor::create([
          'name'  => $request->name,
          'link'  => $request->link,
          'order' => $request->order,
        ]);
        $sponsor->uploadMedia($request->logo);
        session_success(__('messages.sponsor.create', ['name' =>  $sponsor->name]));
        return redirect()->route('admin.sponsor.index');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsor.edit', compact(['sponsor']));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $this->validateSponsor($request, true);
        $sponsor->update([
            'name'  => $request->name,
            'link'  => $request->link,
            'order' => $request->order,
        ]);
        if ($request->hasFile('logo')) {
            $sponsor->clearMediaCollection();
            $sponsor->uploadMedia($request->logo);
        }
        session_success(__('messages.sponsor.update', ['name' =>  $sponsor->name]));
        return redirect()->route('admin.sponsor.index');
    }

    public function destroy(Sponsor $sponsor)
    {
        $channel->clearMediaCollection();
        $sponsor->delete();
        return $sponsor;
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
