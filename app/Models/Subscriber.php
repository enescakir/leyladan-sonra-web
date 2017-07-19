<?php

namespace App\Models;

class Subscriber extends BaseModel
{
  // Properties
  protected $table    = 'subscribers';
  protected $fillable = ['notification_toke'];
}
