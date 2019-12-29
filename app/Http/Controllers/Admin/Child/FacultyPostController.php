<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\PostFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $posts = $faculty->posts()->latest('posts.created_at')->with(['child', 'child.faculty', 'media'])->filter($filters)->safePaginate();

        $postTypes = PostType::toSelect('Hepsi');

        return view('admin.faculty.post.index', compact('posts', 'faculty', 'postTypes'));
    }

    public function edit(Faculty $faculty, Post $post)
    {
        return view('admin.faculty.post.edit', compact('post', 'faculty'));
    }

}
