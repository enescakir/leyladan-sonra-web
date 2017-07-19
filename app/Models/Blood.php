<?php

namespace App\Models;

use App\Traits\Mobile;

class Blood extends BaseModel
{
  use Mobile;

  // Properties
  protected $table    = 'bloods';
  protected $fillable = ['rh', 'mobile', 'city', 'blood_type'];

  // Validation rules
  public static $createRules = [
    'rh'         =>'required',
    'mobile'     =>'required|unique:bloods|max:255',
    'city'       =>'required|max:255',
    'blood_type' =>'required',
  ];
}
