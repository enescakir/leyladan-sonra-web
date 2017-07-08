<?php

namespace App;

class Sponsor extends BaseModel
{
  // Properties
  protected $table    = 'sponsors';
  protected $fillable = ['name', 'link', 'order'];
}
