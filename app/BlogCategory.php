<?php

namespace App;

class BlogCategory extends BaseModel
{
    protected $table = 'blog_categories';

    protected $guarded = [];

    public function blogs(){
        return $this->belongsToMany('App\Blog','blog_category','category_id', 'blog_id')->withTimestamps();
    }

}
