<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\PostFilter;
use App\Http\Controllers\Controller;
use App\Enums\PostType;
use App\Models\Faculty;
use App\Models\Post;

class FacultyPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PostFilter $filters, Faculty $faculty)
    {
        $this->authorize('listFaculty', [Post::class, $faculty]);

        $posts = $faculty->posts()
            ->filter($filters)
            ->latest('posts.created_at')
            ->with(['child', 'child.faculty', 'media'])
            ->safePaginate();

        $postTypes = PostType::toSelect('Hepsi');

        return view('admin.faculty.post.index', compact('posts', 'faculty', 'postTypes'));
    }

    public function edit(Faculty $faculty, Post $post)
    {
        $this->authorize('update', $post);

        return view('admin.faculty.post.edit', compact('post', 'faculty'));
    }

}
