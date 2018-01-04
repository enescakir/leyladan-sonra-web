<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Diagnosis extends Model
{
    use Base;
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
