<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\PostFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\PostType;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PostFilter $filters)
    {
        $this->authorize('listAll', Post::class);

        $posts = Post::filter($filters)->with(['child', 'child.faculty', 'media'])->latest()->safePaginate();

        $postTypes = PostType::toSelect('Hepsi');

        return view('admin.post.index', compact('posts', 'postTypes'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->only(['text']));

        session_success("<strong>{$post->child->full_name}</strong> yazısı başarıyla güncellendi.");

        if ($request->approval) {
            $post->approve();
        }

        return redirect()->to(request('redirect', route('admin.post.edit', $post->id)));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return api_success(['post' => $post]);
    }

    public function approve(Request $request, Post $post)
    {
        $this->authorize('approve', $post);

        $post->approve($request->approval);

        return api_success([
            'approval' => (int)$post->isApproved(),
            'post'     => $post
        ]);
    }
}
