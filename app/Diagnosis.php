<?php

namespace App;

class Diagnosis extends BaseModel
{
  // Properties
  protected $table    = 'diagnoses';
  protected $fillable = ['name', 'category', 'desc'];

  // Global Methods
  public static function toSelect($empty = false)
  {
    $res = Diagnosis::orderBy('name')->pluck('name', 'name');
    return $empty ? collect(['' => ''])->merge($res) : $res;
  }
}
