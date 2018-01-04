<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Sponsor extends Model
{
    use Base;
    // Properties
    protected $table    = 'sponsors';
    protected $fillable = ['name', 'link', 'order', 'logo'];
    protected static $cacheKeys = [
        'sponsors'
    ];
}
