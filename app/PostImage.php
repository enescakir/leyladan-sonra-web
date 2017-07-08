<?php

namespace App;

class PostImage extends BaseModel
{
  // Properties
  protected $table    = 'post_images';
  protected $fillable = ['name', 'ratio', 'post_id'];

  // Relations
  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  // Scopes
  public function scopeRatio($query, $ratio)
  {
    $query->where('ratio', $ratio);
  }

}


class ImageRatio extends SplEnum
{
  const Portrait  = '2/3';
  const Landscape = '4/3';
}
