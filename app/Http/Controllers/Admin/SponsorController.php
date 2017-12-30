<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Sponsor;
use Excel;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sponsors = Sponsor::orderBy('order', 'DESC');
        if ($request->has('search')) {
            $sponsors = $sponsors
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('link', 'like', '%' . $request->search . '%');
        }
        if ($request->has('csv')) {
            $sponsors = $sponsors->get(['id', 'name', 'link', 'logo', 'created_at']);
            Excel::create('LS_Destekciler_' . date("d_m_Y"), function ($excel) use ($sponsors) {
                $sponsors = $sponsors->each(function ($item, $key) {
                    $item->logo = asset(upload_path("sponsor", $item->logo));
                });
                $excel->sheet('Destekciler', function ($sheet) use ($sponsors) {
                    $sheet->fromArray($sponsors, null, 'A1', true);
                });
            })->download('xlsx');
        }
        $sponsors = $sponsors->paginate(25);
        return view('admin.sponsor.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sponsor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateSponsor($request);
        $sponsor = Sponsor::create([
          'name'  => $request->name,
          'link'  => $request->link,
          'order' => $request->order,
        ]);
        $sponsor->uploadImage($request->logo, 'logo', 'sponsor', 400, 100, 'png');
        session_success(__('messages.sponsor.create', ['name' =>  $sponsor->name]));
        return redirect()->route('admin.sponsor.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsor.edit', compact(['sponsor']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $this->validateSponsor($request, true);
        $sponsor->update([
          'name'  => $request->name,
          'link'  => $request->link,
          'order' => $request->order,
      ]);
        if ($request->hasFile('logo')) {
            $sponsor->deleteImage('logo', 'sponsor', true);
            $sponsor->uploadImage($request->logo, 'logo', 'sponsor', 400, 100, 'png');
        }
        session_success(__('messages.sponsor.update', ['name' =>  $sponsor->name]));
        return redirect()->route('admin.sponsor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->deleteImage('logo', 'sponsor', true);
        $sponsor->delete();
        return $sponsor;
    }

    private function validateSponsor(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
          'name'  => 'required|string|max:255',
          'link'  => 'required|string',
          'order' => 'required|integer',
          'logo'  => 'image'. ($isUpdate ? '' : '|required'),
        ]);
    }
}
