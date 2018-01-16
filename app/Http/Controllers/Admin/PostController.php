<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Process;
use App\Models\Faculty;

use App\Enums\PostType;

use Image;
use Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $posts = Post::with(['child', 'child.faculty', 'images'])->orderBy('id', 'DESC');
        if ($request->filled('search')) {
            $posts = $posts->search($request->search);
        }
        if ($request->filled('faculty_id')) {
            $posts = $posts->faculty($request->faculty_id);
        }
        if ($request->filled('type')) {
            $posts = $posts->type($request->type);
        }
        if ($request->filled('approval')) {
            $posts = $posts->approved($request->approval);
        }
        $posts = $posts->paginate($request->per_page ?: 25);
        $faculties = Faculty::toSelect('Hepsi');
        $post_types = PostType::toSelect('Hepsi');
        return view('admin.post.index', compact(['posts', 'faculties', 'post_types']));
    }

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

    public function unapproved()
    {
        $user = Auth::user();
        $posts = Post::select('id', 'approved_at', 'text', 'type', 'faculty_id', 'child_id', 'image')->with('child')->where('faculty_id', $user->faculty_id)->whereNull('approved_at')->get();
        return view('admin.post.unapproved', compact(['posts']));
    }

    public function edit(Post $post)
    {
        $post = Post::whereId($id)->with('child', 'child.faculty', 'images')->first();
        return view('admin.post.edit', compact(['post']));
    }

    public function destroy(Post $post)
    {
        $post->images()->delete();
        $post->delete();
        return $post;
    }

    public function approve(Request $request, Post $post)
    {
        $post->approve($request->approve);
        return $request->approve;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        $post = Post::whereId($id)->with('child')->first();
        $post->text = $request->get('post_text');
        if ($request->hasFile('post_image')) {
            $imageSize = 800;
            if ($request->ratio == '2/3') {
                $imageSize = 400;
            }

            if (count($post->images) == 0) {
                $postImage = new PostImage();
                $postImage->post_id = $post->id;
                if ($post->type == 'Tanışma') {
                    $postImage->name = $post->child->id . '_1.jpg';
                } elseif ($post->type == 'Hediye') {
                    $postImage->name = $post->child->id . '_2.jpg';
                }
                $postImage->ratio = $request->ratio;
                $postImage->save();
            } else {
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

        if ($request->get('approve') == 1) {
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
