<?php

namespace App\Models;

class Channel extends BaseModel
{
  // Properties
  protected $table    = 'channels';
  protected $fillable = ['name', 'logo', 'category'];

  // Relations
  public function news()
  {
    return $this->hasMany(News::class);
  }

  // Global Methods
  public static function toSelect($empty = false)
  {
    $res = Channel::orderBy('name')->pluck('name', 'id');
    return $empty ? collect(['' => ''])->merge($res) : $res;
  }

}
