<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Auth;
use Datatables;
use File;
use Log;
use DB;
use Session;
use App\Models\Faculty;
use App\Models\Child;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Carbon\Carbon;

class FacultyController extends AdminController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $faculties = Faculty::with('responsibles')->get();
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

        if ($request->next == '1') {
            return redirect()->route('admin.faculty.create');
        } else {
            return redirect()->route('admin.faculty.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faculty = Faculty::where('id', $id)->with('responsibles')->first();
        return view('admin.faculty.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faculty = Faculty::where('id', $id)->with('responsibles')->first();
        $users = User::select('id', DB::raw('CONCAT(first_name, " ", last_name) AS fullname2'), 'faculty_id')->where('faculty_id', $faculty->id)->orderby('first_name')->pluck('fullname2', 'id');
        $responsibles = $faculty->responsibles()->pluck('id')->toArray();

        return view('admin.faculty.edit', compact('faculty', 'users', 'responsibles'));
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
        $this->validate($request, Faculty::$validationRules, Faculty::$validationMessages);
        $faculty = Faculty::find($id);
        $faculty->update($request->except(['next', 'users']));
        if ($faculty->save()) {
            Session::flash('success_message', $faculty->full_name . ' Tıp Fakültesi başarıyla güncellendi.');
        } else {
            Session::flash('error_message', $faculty->full_name . ' Tıp Fakültesi güncellenemedi.');
            return redirect()->back()->withInput();
        }

        if (User::where('faculty_id', $id)->where('title', 'Fakülte Sorumlusu')->update(['title' => 'Fakülte Yönetim Kurulu'])
            && User::where('faculty_id', $id)->whereIn('id', $request->users)->update(['title' => 'Fakülte Sorumlusu'])) {
        } else {
            Session::flash('error_message', $faculty->full_name . ' Tıp Fakültesi sorumluları güncellenemedi.');
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.faculty.show', $id);
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

    public function children(Request $request, $id)
    {
        $faculty = Faculty::find($id);
        if ($request->ajax()) {
            $user = Auth::user();
            return Datatables::eloquent(
            Child::select('id', 'first_name', 'last_name', 'department', 'diagnosis', 'wish', 'birthday', 'gift_state', 'meeting_day', 'faculty_id', 'until')
              ->where('faculty_id', $faculty->id)
              ->with('users')
        )
          ->editColumn('operations', '
            <div class="btn-group">
                <a class="btn purple" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user"></i> Settings
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-plus"></i> Add </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-trash-o"></i> Edit </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-times"></i> Delete </a>
                    </li>
                    <li class="divider"> </li>
                    <li>
                        <a href="javascript:;">
                            <i class="i"></i> Full Settings </a>
                    </li>
                </ul>
            </div>
            @if (Auth::user()->title == "Yönetici" || Auth::user()->title == "Fakülte Sorumlusu" || Auth::user()->title == "Fakülte Yönetim Kurulu")
                <a class="btn btn-primary" href="{{ route("admin.child.show", $id) }}"><i class="fa fa-search"></i></a>
                <a class="edit btn btn-success" href="{{ route("admin.child.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                <a class="delete btn btn-danger" href="javascript:;"><i class="fa fa-trash"></i> </a>
            @elseif(Auth::user()->title == "İletişim Sorumlusu")
                <a class="road btn btn-default btn-sm" href="javascript:;"> Gönüllü bulundu </a>
            @elseif(Auth::user()->title == "Site Sorumlusu")
                <a class="post btn btn-default btn-sm" href="{{ route("admin.faculty.posts", Auth::user()->faculty_id) }}"> Yazısını göster </a>
            @elseif(Auth::user()->title == "Hediye Sorumlusu")
                <a class="gift btn btn-default btn-sm" href="javascript:;"> Hediyesi geldi </a>
            @endif
          ')
            ->editColumn('first_name', '{{ $full_name }}')
            // ->editColumn('gift_state',' @if ($gift_state == "Bekleniyor")
            //                             <td><span class="label label-danger"> Bekleniyor </span></td>
            //                         @elseif ($gift_state == "Yolda")
            //                             <td><span class="label label-warning"> Yolda </span></td>
            //                         @elseif ($gift_state == "Bize Ulaştı")
            //                             <td><span class="label label-primary"> Bize Ulaştı </span></td>
            //                         @elseif ($gift_state == "Teslim Edildi")
            //                             <td><span class="label label-success"> Teslim Edildi </span></td>
            //                         @else
            //                             <td><span class="label label-default"> Problem </span></td>
            //                         @endif')
            // ->editColumn('until','@if ($until == null )
            //                             <td><span class="label label-danger"> Hata </span></td>
            //                         @elseif ((new \Carbon\Carbon($until))->isFuture())
            //                             <td><span class="label label-success"> {{date("d.m.Y", strtotime($until))}} </span></td>
            //                         @elseif ((new \Carbon\Carbon($until))->isPast())
            //                             <td><span class="label label-warning"> {{date("d.m.Y", strtotime($until))}} </span></td>
            //                         @endif')
            ->editColumn('users', function ($child) {
                return $child->users->implode('full_name', ',');
            })
            ->editColumn('birthday', '{{ date("d.m.Y", strtotime($birthday)) }}')
            ->editColumn('meeting_day', '{{ date("d.m.Y", strtotime($meeting_day)) }}')
            ->rawColumns(['operations'])
            ->make(true);
        }
        return view('admin.faculty.children', compact(['faculty']));
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
        return Datatables::eloquent(
            Child::select('id', 'first_name', 'last_name', 'department', 'diagnosis', 'wish', 'birthday', 'gift_state', 'meeting_day', 'faculty_id', 'until')->where('faculty_id', $faculty->id)->with('users')
        )
            ->editColumn('operations', '
                                    @if (Auth::user()->title == "Yönetici" || Auth::user()->title == "Fakülte Sorumlusu" || Auth::user()->title == "Fakülte Yönetim Kurulu")
                                        <a class="btn btn-primary btn-sm" href="{{ route("admin.child.show", $id) }}"><i class="fa fa-search"></i></a>
                                        <a class="edit btn btn-success btn-sm" href="{{ route("admin.child.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                                        <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>
                                    @elseif(Auth::user()->title == "İletişim Sorumlusu")
                                        <a class="road btn btn-default btn-sm" href="javascript:;"> Gönüllü bulundu </a>
                                    @elseif(Auth::user()->title == "Site Sorumlusu")
                                        <a class="post btn btn-default btn-sm" href="{{ route("admin.faculty.posts", Auth::user()->faculty_id) }}"> Yazısını göster </a>
                                    @elseif(Auth::user()->title == "Hediye Sorumlusu")
                                        <a class="gift btn btn-default btn-sm" href="javascript:;"> Hediyesi geldi </a>
                                    @endif
                              ')
            // ->editColumn('first_name','{{$full_name}}')
            // ->editColumn('gift_state',' @if ($gift_state == "Bekleniyor")
            //                             <td><span class="label label-danger"> Bekleniyor </span></td>
            //                         @elseif ($gift_state == "Yolda")
            //                             <td><span class="label label-warning"> Yolda </span></td>
            //                         @elseif ($gift_state == "Bize Ulaştı")
            //                             <td><span class="label label-primary"> Bize Ulaştı </span></td>
            //                         @elseif ($gift_state == "Teslim Edildi")
            //                             <td><span class="label label-success"> Teslim Edildi </span></td>
            //                         @else
            //                             <td><span class="label label-default"> Problem </span></td>
            //                         @endif')
            // ->editColumn('until','@if ($until == null )
            //                             <td><span class="label label-danger"> Hata </span></td>
            //                         @elseif ((new \Carbon\Carbon($until))->isFuture())
            //                             <td><span class="label label-success"> {{date("d.m.Y", strtotime($until))}} </span></td>
            //                         @elseif ((new \Carbon\Carbon($until))->isPast())
            //                             <td><span class="label label-warning"> {{date("d.m.Y", strtotime($until))}} </span></td>
            //                         @endif')
            // ->editColumn('users','{{implode(\', \', array_map(function($user){ return $user[\'full_name\']; }, $users))}}')
            // ->editColumn('birthday','{{date("d.m.Y", strtotime($birthday))}}')
            // ->editColumn('meeting_day','{{date("d.m.Y", strtotime($meeting_day))}}')
            ->make(true);
    }

    /**
     * Display a listing of faculty's posts.
     *
     * @return Response
     */
    public function posts($id)
    {
        $faculty = Faculty::find($id);
        return view('admin.faculty.posts', compact(['faculty']));
    }

    public function postsData($id, Request $request)
    {
        $faculty = Faculty::find($id);
        $user = Auth::user();
        if ($request->has('unapproved')) {
            $posts = $faculty->posts()->whereNull('approved_at')->with('child', 'images')->get();
        } else {
            $posts = $faculty->posts()->with('child', 'images')->get();
        }

        return Datatables::of($posts)
            ->addColumn('operations', '
                <a class="approve btn btn-success btn-sm" href="javascript:;"><i class="fa fa-check"></i></a>
                <a class="edit btn btn-primary btn-sm" href="{{ route("admin.post.edit", $id) }}"><i class="fa fa-pencil"></i> </a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>')
            ->editColumn('status', ' @if ($approved_at != null)
                            <span class="label label-success"> Onaylandı </span>
                        @else
                            <span class="label label-danger"> Onaylanmadı </span>
                        @endif')
            ->editColumn('images', '
                        @forelse ($images as $image)
                            <img src="{{ asset("resources/admin/uploads/child_photos/". $image[\'name\']) }}" class="img-responsive"/>
                        @empty
                            <img src="{{ asset("resources/admin/media/child_no_image.jpg") }}" class="img-responsive"/>
                        @endforelse
                        ')
            ->make(true);
    }

    public function postsUnapproved($id)
    {
        $faculty = Faculty::find($id);
        return view('admin.faculty.posts_unapproved', compact(['faculty']));
    }

    public function postsUnapprovedCount($id)
    {
        $faculty = Faculty::find($id);
        return $faculty->posts()->whereNull('approved_at')->count();
    }

    public function profiles($id)
    {
        $faculty = Faculty::find($id);

        $users = $faculty->users()
            ->orderby('first_name')
            ->where('profile_photo', '!=', 'default')
            ->simplePaginate(16);
        return view('admin.faculty.profiles', compact(['faculty', 'users']));
    }

    public function users($id)
    {
        $faculty = Faculty::find($id);
        return view('admin.faculty.users', compact(['faculty']));
    }

    public function usersData($id)
    {
        $faculty = Faculty::find($id);
        $user = Auth::user();
        return Datatables::of($faculty->users)
            ->addColumn('operations', '
                <a class="approve btn btn-success btn-sm" href="javascript:;"><i class="fa fa-check"></i></a>
                <a class="title btn blue-steel btn-sm"  data-toggle="modal" data-target="#titleModal"><i class="fa fa-sitemap"></i></a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>')
            ->editColumn('activated_by', '
                        @if ($activated_by != null)
						    <span class=\'label label-success\'> Onaylandı </span>
                        @else
						    <span class=\'label label-danger\'> Onaylanmadı </span>
                        @endif')
            ->editColumn('birthday', '{{date("d.m.Y", strtotime($birthday))}}')
            ->make(true);
    }

    public function unapproved($id)
    {
        $faculty = Faculty::find($id);
        $users = $faculty->users()->whereNull('activated_by')->get();
        return view('admin.faculty.unapproved', compact(['faculty', 'users']));
    }

    public function unapprovedData($id)
    {
        $faculty = Faculty::find($id);
        return Datatables::of($faculty->users()->whereNull('activated_by')->get())
            ->addColumn('operations', '
                <a class="approve btn btn-success btn-sm" href="javascript:;"><i class="fa fa-check"></i></a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>')
            ->editColumn('activated_by', '
                        @if ($activated_by != null)
						    <span class=\'label label-success\'> Onaylandı </span>
                        @else
						    <span class=\'label label-danger\'> Onaylanmadı </span>
                        @endif')
            ->editColumn('birthday', '{{date("d.m.Y", strtotime($birthday))}}')
            ->make(true);
    }

    public function unapprovedCount($id)
    {
        $faculty = Faculty::find($id);
        return $faculty->users()->whereNull('activated_by')->count();
    }

    public function messages($id)
    {
        $authUser = Auth::user();
        $colors = ['purple', 'red', 'green'];
        $faculty = Faculty::find($id);
        $children = $faculty->children()->has('chats')->withCount('chats')->orderBy('id', 'desc')->get();
        return view('admin.faculty.messages', compact(['children', 'faculty', 'colors', 'authUser']));
    }

    public function messagesUnanswered($id)
    {
        $authUser = Auth::user();
        $colors = ['purple', 'red', 'green'];
        $faculty = Faculty::find($id);
        $children = $faculty->children()->has('openChats')->withCount('openChats', 'unansweredMessages')->orderBy('id', 'desc')->get();
        return view('admin.faculty.messages_unanswered', compact(['children', 'faculty', 'colors', 'authUser']));
    }

    public function createMail($id)
    {
        $facultyId = $id;
        return view('admin.faculty.send_mail', compact(['facultyId']));
    }

    public function sendMail(Request $request, $id)
    {
        $sender = Auth::user();
        if (!($sender->title == 'Yönetici' || $sender->title == 'Fakülte Sorumlusu')) {
            return redirect()->back()->withInput()->with('error_message', 'Fakülte üyelerine e-posta gönderme yetkisine sahip değilsiniz.');
        }
        $titles = $request->title;
        $users = User::where('faculty_id', $id)->whereIn('title', $titles)->get();
        $text = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', strip_tags($request->text, '<p><br><i><b><u><ul><li><ol><h1><h2><h3><h4><h5>'));
        $subject = $request->subject;
        foreach ($users as $user) {
            \Mail::send('email.admin.faculty', ['user' => $user, 'text' => $text, 'sender' => $sender], function ($message) use ($user, $subject) {
                $message
                    ->to($user->email)
                    ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
                    ->subject($subject);
            });
        }
        $user = User::find(1);
        \Mail::send('email.admin.faculty', ['user' => $user, 'text' => $text, 'sender' => $sender], function ($message) use ($user, $subject) {
            $message
                    ->to($user->email)
                    ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
                    ->subject($subject);
        });
        return redirect()->back()->with('success_message', count($users) . ' kişiye başarılı bir şekilde e-posta gönderildi.');
    }
}
