<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Testimonial;
use Session, Datatables;
class TestimonialController extends Controller
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
//        $testimonials = Testimonial::all();
        return view('admin.testimonial.index');
    }

    public function indexData()
    {
        return Datatables::of(Testimonial::all())
            ->addColumn('operations','
                <a class="approve btn btn-success btn-sm" href="javascript:;"><i class="fa fa-check"></i></a>
                <a class="edit btn btn-primary btn-sm" href="{{ route("admin.testimonial.edit", $id) }}"><i class="fa fa-pencil"></i> </a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>
           ')
            ->editColumn('approved_at','@if ($approved_at != null)
                                <span class="label label-success"> Onaylandı </span>
                            @else
                                <span class="label label-danger"> Onaylanmadı </span>
                            @endif')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Testimonial::$validationRules, Testimonial::$validationMessages);
        $testimonial = new Testimonial($request->except('next'));
        if($testimonial->save()){
            Session::flash('success_message', $testimonial->name . '\'in referansı başarıyla sisteme kaydedildi..');
        }else{
            Session::flash('error_message',  $testimonial->name . '\'in referansını eklerken bir sorun ile karşılaşıldı.');
            return redirect()->back()->withInput();
        }

        if($request->next == 1){
            return redirect()->route('admin.testimonial.create');
        }
        return redirect()->route('admin.testimonial.index');

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
        if( Testimonial::destroy($id))
            return http_response_code(200);

    }
}
