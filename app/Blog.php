<?php

namespace App;

class Blog extends BaseModel
{
  // Properties
  protected $table    = 'blogs';
  protected $fillable = ['title', 'text', 'thumb', 'slug', 'type', 'link'];
  protected $slugKeys = ['title', 'id'];

  // Validation rules
  public static $createRules = [
    'title'      =>'required|max:255',
    'categories' =>'required',
    'thumb'      =>'image',
    'type'       =>'required',
  ];

  // Relations
  public function categories()
  {
    return $this->belongsToMany(BlogCategory::class,'blog_category','blog_id', 'category_id')->withTimestamps();
  }

  // Mutators
  public function setTextAttribute($text)
  {
    return $this->attributes['text'] = clean_text($text);
  }
}

// TODO: Complete blog types
class BlogType extends SplEnum {
  const Milestone = 'milestone';
  const Video     = 'video';
}
