<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\PostFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Process;
use App\Models\Faculty;
use App\Enums\PostType;
use Image;
use Auth;
use Carbon\Carbon;

class PostController extends AdminController
{

    public function index(PostFilter $filters)
    {
        $posts = Post::with(['child', 'child.faculty', 'media'])->latest();
        $posts->filter($filters);
        $posts = $posts->paginate();

        $postTypes = PostType::toSelect('Hepsi');
        return view('admin.post.index', compact('posts', 'postTypes'));
    }

    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
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
            $process->desc = 'Çocuğun yazısı onaylandı.';
            $process->save();
        }

        return redirect()->route('admin.faculty.posts', $post->child->faculty_id);
    }

    public function destroy(Post $post)
    {
        $post->images()->delete();
        $post->delete();
        return $post;
    }

    public function approve(Request $request, Post $post)
    {
        $post->approve($request->approval);

        return api_success([
            'approval' => (int) $post->isApproved(),
            'post'     => $post
        ]);

    }
}