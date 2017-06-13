<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
  protected $guarded = [];

  public static function toSelect($empty = false)
  {
    $res = Diagnosis::orderBy('name')->pluck('name', 'name');
    return $empty ? collect(['' => ''])->merge($res) : $res;
  }
}
