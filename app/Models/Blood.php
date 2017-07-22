<?php

namespace App\Models;

use App\Traits\Mobile;

class Blood extends BaseModel
{
  use Mobile;

  // Properties
  protected $table    = 'bloods';
  protected $fillable = ['rh', 'mobile', 'city', 'blood_type'];
}
