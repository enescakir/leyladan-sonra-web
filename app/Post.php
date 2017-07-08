<?php

namespace App;

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
}
