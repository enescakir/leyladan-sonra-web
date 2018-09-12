<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Enums\GiftStatus;
use App\Enums\PostType;
use App\Enums\UserTitle;
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

class FacultyPostController extends AdminController
{
    public function faculty(Request $request, Faculty $faculty)
    {
        $posts = $faculty->posts()->with(['child', 'child.faculty', 'images'])->orderBy('id', 'DESC');
        if ($request->filled('search')) {
            $posts = $posts->search($request->search);
        }
        if ($request->filled('type')) {
            $posts = $posts->type($request->type);
        }
        if ($request->filled('approval')) {
            $posts = $posts->approved($request->approval);
        }
        $posts = $posts->paginate($request->per_page ?: 25);
        $post_types = PostType::toSelect('Hepsi');
        return view('admin.post.faculty', compact(['posts', 'faculty', 'post_types']));
    }

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

}
