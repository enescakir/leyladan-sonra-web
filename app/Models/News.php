<?php

namespace App\Models;

class News extends BaseModel
{
  protected $table    = 'news';
  protected $fillable = ['title', 'desc', 'link', 'channel_id'];

  public function channel()
  {
    return $this->belongsTo(Channel::class);
  }
}
