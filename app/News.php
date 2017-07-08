<?php

namespace App;

class News extends BaseModel
{
  protected $table    = 'news';
  protected $fillable = ['title', 'desc', 'link', 'channel_id'];

  public function news()
  {
    return $this->hasMany(News::class);
  }

  public function channel()
  {
    return $this->belongsTo(Channel::class);
  }
}
