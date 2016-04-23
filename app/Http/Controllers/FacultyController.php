<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Datatables, Auth;
use App\Faculty, App\Child;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::all();
        return view('admin.faculty.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faculty.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Faculty::$validationRules, Faculty::$validationMessages);
        $faculty = new Faculty($request->except('next'));
        $faculty->save();

        if($request->next == "1"){ return redirect()->route('admin.faculty.create'); }
        else{ return redirect()->route('admin.faculty.index'); }


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

    /**
     * Display a listing of faculty's children.
     *
     * @return Response
     */
    public function children($id)
    {
        $faculty = Faculty::find($id);
        return view('admin.faculty.children', compact(['faculty']));
    }

    /**
     * Display a listing of faculty's children.
     *
     * @return Response
     */
    public function cities()
    {

        $cities = Faculty::lists('id','code')->toArray();

        foreach($cities as $key => $city){
            $cities[$key] = '#339a99';
        }
        return $cities;
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function childrenData($id)
    {

        $faculty = Faculty::find($id);

        $user = Auth::user();
        return Datatables::of(
            Child::select('id', 'first_name', 'last_name', 'department', 'diagnosis', 'wish', 'birthday', 'gift_state', 'meeting_day')->where('faculty_id', $faculty->id)->with('users')->get()
        )
            ->editColumn('operations', '@if (Auth::user()->title == "Yönetici" || Auth::user()->title == "Fakülte Sorumlusu" || Auth::user()->title == "Fakülte Yönetim Kurulu")
                                        <a class="edit btn btn-primary btn-sm" href="{{ route("admin.child.show", $id) }}"><i class="fa fa-search"></i></a>
                                        <a class="edit btn btn-success btn-sm" href="{{ route("admin.child.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                                        <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>
                                    @elseif(Auth::user()->title == "İletişim Sorumlusu")
                                        <a class="road btn btn-default btn-sm" href="javascript:;"> Gönüllü bulundu </a>
                                    @elseif(Auth::user()->title == "Site Sorumlusu")
                                        <a class="post btn btn-default btn-sm" href="{{ route("admin.post.faculty") }}"> Yazısını göster </a>
                                    @elseif(Auth::user()->title == "Hediye Sorumlusu")
                                        <a class="gift btn btn-default btn-sm" href="javascript:;"> Hediyesi geldi </a>
                                    @endif'
            )
            ->editColumn('first_name','{{$first_name . " " . $last_name}}')
            ->editColumn('meeting_day', function($child) {
                return $child->meeting_day;
            })
            ->editColumn('gift_state',' @if ($gift_state == "Bekleniyor")
                                        <td><span class="label label-danger"> Bekleniyor </span></td>
                                    @elseif ($gift_state == "Yolda")
                                        <td><span class="label label-warning"> Yolda </span></td>
                                    @elseif ($gift_state == "Bize Ulaştı")
                                        <td><span class="label label-primary"> Bize Ulaştı </span></td>
                                    @elseif ($gift_state == "Teslim Edildi")
                                        <td><span class="label label-success"> Teslim Edildi </span></td>
                                    @else
                                        <td><span class="label label-default"> Problem </span></td>
                                    @endif')
            // ->editColumn('users', function ($child) {
            //         return $child->user_name_list;
            // })
            ->make(true);
    }


}
