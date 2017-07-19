<?php

namespace App\Models;

class Sponsor extends BaseModel
{
  // Properties
  protected $table    = 'sponsors';
  protected $fillable = ['name', 'link', 'order'];
}
