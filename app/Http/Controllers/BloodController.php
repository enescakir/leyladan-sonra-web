<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Blood;
use Datatables;

class BloodController extends Controller
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
        return view('admin.blood.index');
    }

    public function indexData()
    {
        return Datatables::of(Blood::all())
            ->addColumn('operations','
                <a class="edit btn btn-success btn-sm" href="{{ route("admin.blood.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>
           ')
            ->editColumn('first_name','{{$first_name . " " . $last_name}}')
            ->editColumn('birthday','{{date("d.m.Y", strtotime($birthday))}}')
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blood.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('gender') == '1'){ $request['gender'] = "Bay"; }
        else{ $request['gender'] = "Bayan"; }

        if($request->get('rh') == '1'){ $request['rh'] = 1; }
        else{ $request['rh'] = 0; }


        $this->validate($request, Blood::$validationRules, Blood::$validationMessages);
        $blood = new Blood($request->all());
        $blood->save();
        return redirect()->route('admin.blood.index');
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
        Blood::destroy($id);
        return 'Success';
    }
}
