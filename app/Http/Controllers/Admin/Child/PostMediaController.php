<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Spatie\MediaLibrary\Models\Media;

class PostMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        $this->authorize('media', $post);

        $media = $post->addMedia($request->file('image'), ['ratio' => $request->ratio]);
        $post->approve(false);

        return api_success(['media' => $media, 'child' => $post->child->only(['id', 'full_name'])]);
    }

    public function destroy(Post $post, Media $media)
    {
        $this->authorize('media', $post);

        $media->delete();
        $post->approve(false);

        return api_success();
    }

    public function feature(Post $post, Media $media)
    {
        $this->authorize('media', $post);

        $post->child->featuredMedia()->associate($media);
        $post->child->save();
        $post->approve(false);

        return api_success(['media' => $media]);
    }
}
