<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Post;
use Spatie\MediaLibrary\Models\Media;

class PostMediaController extends AdminController
{
    public function store(Request $request, Post $post)
    {
        $media = $post->addMedia($request->file('image'), ['ratio' => $request->ratio]);
        $post->approve(false);

        return api_success(['media' => $media, 'child' => $post->child->only(['id', 'full_name'])]);
    }

    public function destroy(Post $post, Media $media)
    {
        $media->delete();
        $post->approve(false);

        return api_success();
    }

    public function feature(Post $post, Media $media)
    {
        $post->child->featuredMedia()->associate($media);
        $post->child->save();
        $post->approve(false);

        return api_success(['media' => $media]);
    }
}
