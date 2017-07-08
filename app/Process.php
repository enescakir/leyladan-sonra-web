<?php

namespace App;

class Process extends BaseModel
{
  // Properties
  protected $table    = 'processes';
  protected $fillable = ['child_id', 'desc'];

  // Relations
  public function child()
  {
    return $this->belongsTo(Child::class);
  }
}
