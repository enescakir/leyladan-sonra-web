<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';

    protected $guarded = [];

    public function blogs(){
        return $this->belongsToMany('App\Blog')->withTimestamps();
    }

}
