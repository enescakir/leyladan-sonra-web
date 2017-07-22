<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Sponsor;
use Session, Auth;

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
    public function index()
    {
      $sponsors = Sponsor::orderBy('order', 'DESC')->get();
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
      $sponsor = new Sponsor();
      if($request->has('name')) $sponsor->name = $request->name;
      if($request->has('link')) $sponsor->link = $request->link;
      if($request->has('order')) $sponsor->order = $request->order; else $sponsor->order = 0;
      $sponsor->created_by = Auth::user()->id;

      if($sponsor->save()){
          Session::flash('success_message', 'Destekçi başarıyla kaydedildi.');
      }else{
          Session::flash('error_message',  'Destekçi kaydedilemedi.');
          return redirect()->back()->withInput();
      }
      return redirect()->route('admin.sponsor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
