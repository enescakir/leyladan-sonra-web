<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Post, App\PostImage, Image, Auth, App\Process;
use Carbon\Carbon, Datatables;

class PostController extends Controller
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
        return view('admin.post.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData()
    {
        return Datatables::of(Post::with('child','child.faculty','images')->get())
            ->addColumn('operations', '
                <a class="approve btn btn-success btn-sm" href="javascript:;"><i class="fa fa-check"></i></a>
                <a class="edit btn btn-primary btn-sm" href="{{ route("admin.post.edit", $id) }}"><i class="fa fa-pencil"></i> </a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>')
            ->editColumn('status',' @if ($approved_at != null)
                            <span class="label label-success"> Yayınlandı </span>
                        @else
                            <span class="label label-danger"> Yayınlanmadı </span>
                        @endif')
            ->editColumn('images','
                        @forelse ($images as $image)
                            <img src="{{ asset("resources/admin/uploads/child_photos/". $image->name) }}" class="img-responsive"/>
                        @empty
                            <img src="{{ asset("resources/admin/media/child_no_image.jpg") }}" class="img-responsive"/>
                        @endforelse
                        ')
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
        $post = Post::whereId($id)->with('child','child.faculty','images')->first();
        return view('admin.post.edit', compact(['post']));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return 'Success';
    }

    /**
     * Display a listing of faculty's unapproved posts.
     *
     * @return Admin.Post.Unapproved view with faculty's unapproved posts
     */
    public function unapproved()
    {
        $user = Auth::user();
        $posts = Post::select('id', 'approved_at','text', 'type', 'faculty_id','child_id','image')->with('child')->where('faculty_id',$user->faculty_id)->whereNull('approved_at')->get();
        return view('admin.post.unapproved', compact(['posts']));
    }

    /**
     * Return number of faculty's unapproved posts. I am calling it with AJAX
     *
     * @return Number of faculty's unapproved posts
     */
    public function unapprovedCount()
    {
        $user = Auth::user();
        return DB::table('posts')->where('faculty_id',$user->faculty_id)->whereNull('approved_at')->count();
    }

    /**
     * Approve the selected post in database.
     *
     * @param  int  $id (Post's id)
     * @return Success message
     */
    public function approve(Request $request)
    {
        $post = Post::whereId($request->post_id)->with('child')->first();
        if ($post->approved_at == null) {
            $post->approved_by = Auth::user()->id;
            $post->approved_at = new Carbon();
            $post->save();

            $process = new Process;
            $process->child_id = $post->child->id;
            $process->created_by = Auth::user()->id;
            $process->desc = "Çocuğun yazısı onaylandı.";
            $process->save();

            return 1;
        }
        else {
            $post->approved_by = null;
            $post->approved_at = null;
            $post->save();

            $process = new Process;
            $process->child_id = $post->child->id;
            $process->created_by = Auth::user()->id;
            $process->desc = "Çocuğun yazısının onayı kaldırıldı.";
            $process->save();

            return 0;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::whereId($id)->with('child')->first();
        $post->text = $request->get('post_text');
        if($request->hasFile('post_image') ){
            $imageSize = 800;
            if ($request->ratio == '2/3'){
                $imageSize = 400;
            }

            if( count($post->images) == 0){
                $postImage = new PostImage();
                $postImage->post_id = $post->id;
                if($post->type == 'Tanışma'){
                    $postImage->name = $post->child->id . '_1.jpg';
                }
                elseif($post->type == 'Hediye'){
                    $postImage->name = $post->child->id . '_2.jpg';
                }
                $postImage->ratio = $request->ratio;
                $postImage->save();
            }else{
                $postImage = $post->images()->first();
                $postImage->ratio = $request->ratio;
                $postImage->save();
            }
            $imgPost = Image::make($request->file('post_image'))
                ->rotate(-$request->rotation)
                ->crop($request->w, $request->h, $request->x, $request->y)
                ->resize($imageSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('resources/admin/uploads/child_photos/' . $postImage->name, 80);
            $imgPost->destroy();
        }
        $post->save();

        if($request->get('approve') == 1){
            $post->approved_by = Auth::user()->id;
            $post->approved_at = new Carbon();
            $post->save();

            $process = new Process;
            $process->child_id = $post->child->id;
            $process->created_by = Auth::user()->id;
            $process->desc = "Çocuğun yazısı onaylandı.";
            $process->save();
        }

        return redirect()->route('admin.faculty.posts', $post->child->faculty_id);
    }

}
