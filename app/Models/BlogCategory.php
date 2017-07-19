<?php

namespace App\Models;

class BlogCategory extends BaseModel
{
  // Properties
  protected $table    = 'blog_categories';
  protected $fillable = ['title', 'slug', 'desc'];
  protected $slugKeys = ['title'];

  // Relations
  public function blogs()
  {
    return $this->belongsToMany(Blog::class, 'blog_category', 'category_id', 'blog_id')->withTimestamps();
  }

}
