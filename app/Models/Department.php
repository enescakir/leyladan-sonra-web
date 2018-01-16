<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Department extends Model
{
    use Base;
    // Properties
    protected $table    = 'departments';
    protected $fillable = ['name', 'desc', 'slug'];
    protected $slugKeys = ['name', 'id'];

    // Global Methods
    public static function toSelect($placeholder = false)
    {
        $result = Department::orderBy('name')->pluck('name', 'name');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
