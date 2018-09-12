<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\PostFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Enums\PostType;
use App\Models\Faculty;
use App\Models\Post;

class FacultyPostController extends AdminController
{
    public function index(PostFilter $filters, Faculty $faculty)
    {
        $posts = $faculty->posts()->with(['child', 'child.faculty', 'media'])->latest();
        $posts->filter($filters);
        $posts = $this->paginate($posts);

        $postTypes = PostType::toSelect('Hepsi');

        return view('admin.faculty.post.index', compact('posts', 'faculty', 'postTypes'));
    }

    public function edit(Faculty $faculty, Post $post)
    {
        return view('admin.faculty.post.edit', compact('post', 'faculty'));
    }

}
