<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User, App\Child, App\Process;
use Auth, Datatables,Log, Session, Image, Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function indexData(){
        Log::info('I am here');
        return Datatables::of(User::with('faculty')->get())
            ->addColumn('operations', '
                <a class="approve btn btn-success btn-sm" href="javascript:;"><i class="fa fa-check"></i></a>
                <a class="edit btn btn-primary btn-sm" href="{{ route("admin.user.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>')
            ->editColumn('activated_by','
                        @if ($activated_by != null)
						    <span class=\'label label-success\'> Onaylandı </span>
                        @else
						    <span class=\'label label-danger\'> Onaylanmadı </span>
                        @endif')
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->child_count = $user->children()->count();
        $user->visit_count = Process::where('creator_id', $user->id)->where('desc', 'Ziyaret edildi.')->count();
        $user->child_delivered_count = $user->children()->where('gift_state', 'Teslim Edildi')->count();
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $user->child_count = $user->children()->count();
        $user->visit_count = Process::where('creator_id', $user->id)->where('desc', 'Ziyaret edildi.')->count();
        $user->child_delivered_count = $user->children()->where('gift_state', 'Teslim Edildi')->count();
        return view('admin.user.edit', compact('user'));
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
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        if($request->has('form')){
            Session::flash('success_message', 'Bilgilerin başarıyla güncellendi.');
            return redirect()->route('admin.user.edit', $id);
        }

        if($request->hasFile('photo')){
            ini_set("memory_limit","-1");
            $smallPhoto = Image::make($request->file('photo'))
                ->rotate(-$request->rotation)
                ->crop($request->w, $request->h, $request->x, $request->y)
                ->resize(100,100)
                ->save('resources/admin/uploads/profile_photos/' . $user->id . '_s.jpg', 80);

            $largePhoto = Image::make($request->file('photo'))
                ->rotate(-$request->rotation)
                ->crop($request->w, $request->h, $request->x, $request->y)
                ->resize(600,600)
                ->save('resources/admin/uploads/profile_photos/' . $user->id . '_l.jpg', 80);

            ini_restore("memory_limit");

            $user->profile_photo = $user->id;
            $user->save();

            Session::flash('success_message', 'Fotoğrafınız başarıyla güncellendi.');
            return redirect()->route('admin.user.edit', $id);
        }


        return http_response_code(200);
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

    public function children($id){
        $user = User::find($id);
        $user->child_count = $user->children()->count();
        $user->visit_count = Process::where('creator_id', $user->id)->where('desc', 'Ziyaret edildi.')->count();
        $user->child_delivered_count = $user->children()->where('gift_state', 'Teslim Edildi')->count();
        $children = $user->children()->get();
        return view('admin.user.children', compact('children', 'user'));
    }

    public function childrenData($id){

    }


    public function approve(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if($user->activated_by == null){
            $user->activated_by = Auth::user()->id;
            $user->save();
            Mail::send('email.admin.activation', ['user' => $user], function ($m) use ($user) {
                $m->to($user->email)->subject('Hesabınız artık aktif!');
            });
            return 1;
        }
        else{
            $user->activated_by = null;
            $user->save();
            return 0;
        }
        $user->save();
    }


}
