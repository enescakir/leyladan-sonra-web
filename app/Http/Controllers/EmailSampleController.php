<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailSample, Auth, Session;
use App\Http\Requests;

class EmailSampleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailsamples = EmailSample::with('creator')->orderBy('category')->get();
        $authUser = Auth::user();
        return view('admin.emailsample.index', compact('emailsamples', 'authUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.emailsample.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sample = new EmailSample();
        if($request->has('name')) $sample->name = $request->name;
        if($request->has('category')) $sample->category = $request->category;
        if($request->has('text')) $sample->text = $request->text;
        $sample->created_by = Auth::user()->id;

        if($sample->save()){
            Session::flash('success_message', 'E-posta örneği başarıyla kaydedildi.');
        }else{
            Session::flash('error_message',  'E-posta örneği kaydedilemedi.');
            return redirect()->back()->withInput();
        }
        return redirect()->route('admin.emailsample.index');
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
