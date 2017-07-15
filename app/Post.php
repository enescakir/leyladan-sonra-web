<?php

namespace App;

use App\Enums\ImageRatio;

class Post extends BaseModel
{
  // Properties
  protected $table    = 'posts';
  protected $fillable = ['child_id', 'approved_by', 'approved_at', 'text', 'type'];
  protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'approved_at'];

  // Relations
  public function child()
  {
    return $this->belongsTo(Child::class);
  }

  public function images()
  {
    return $this->hasMany(PostImage::class);
  }

  // Mutators
  public function setTextAttribute($text)
  {
    return $this->attributes['text'] = clean_text($text);
  }

  // Scopes
  public function scopeMeetingPost($query, $id)
  {
    $query->where('type', PostType::Meeting)->where('child_id', $id);
  }

  public function scopeGiftPost($query, $id)
  {
    $query->where('type', PostType::Delivery)->where('child_id', $id);
  }

  public function scopeApproved($query)
  {
    $query->whereNotNull('approved_at');
  }

  // Helpers
  public function addImage($file, $data)
  {
    $postImage = PostImage::create([
      'post_id' => $this->id,
      'name'    => $child->id . str_random(5) . '.jpg',
      'ratio'   => $data['ratio'],
    ]);

    $imageWidth = $data['ratio'] == ImageRatio::Landscape ? 1000 : 800;
    // Increase limits for image process
    ini_set('max_execution_time', 300);
    ini_set('memory_limit', '-1');
    Image::make($file)
      ->rotate(-$data['rotation'])
      ->crop($data['w'], $data['h'], $data['x'], $data['y'])
      ->resize($imageWidth, null, function ($constraint) { $constraint->aspectRatio(); })
      ->save( upload_path('child') . '/' . $postImage->name, 90 );
    ini_restore("memory_limit");
    ini_restore("max_execution_time");
  }
}
