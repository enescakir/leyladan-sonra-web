<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{
  // Properties
  protected $table    = 'departments';
  protected $fillable = ['name', 'desc', 'slug'];
  protected $slugKeys = ['name', 'id'];

  // Global Methods
  public static function toSelect($empty = false)
  {
    $res = Department::orderBy('name')->pluck('name', 'name');
    return $empty ? collect(['' => ''])->merge($res) : $res;
  }
}
