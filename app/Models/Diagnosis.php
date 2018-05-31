<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Base;

class Diagnosis extends Model
{
    use Base;
    // Properties
    protected $table = 'diagnoses';
    protected $fillable = ['name', 'category', 'desc'];

    // Global Methods
    public static function toSelect($placeholder = null)
    {
        $result = static::orderBy('name')->pluck('name', 'name');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
