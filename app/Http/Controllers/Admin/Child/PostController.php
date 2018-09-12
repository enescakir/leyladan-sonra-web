<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\PostFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\PostType;

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
        $post->update($request->only(['text']));

        session_success("<strong>{$post->child->full_name}</strong> yazısı başarıyla güncellendi.");

        if ($request->approval) {
            $post->approve();
        }

        return redirect()->to(request('redirect', route('admin.post.edit', $post->id)));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return api_success(['post' => $post]);
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
