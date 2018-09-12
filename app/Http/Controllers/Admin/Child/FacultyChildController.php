<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Enums\GiftStatus;
use App\Enums\PostType;
use App\Enums\UserRole;
use App\Http\Requests\CreateChildRequest;
use App\Models\Child;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Diagnosis;
use App\User;
use App\Post;
use App\PostImage;
use App\Process;
use App\Feed;
use App\Chat;
use App\Volunteer;
use Auth;
use Carbon\Carbon;
use File;
use App\Filters\ChildFilter;

class FacultyChildController extends AdminController
{
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


}
