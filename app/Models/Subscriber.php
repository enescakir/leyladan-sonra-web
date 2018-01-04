<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Subscriber extends Model
{
    use Base;
    // Properties
    protected $table    = 'subscribers';
    protected $fillable = ['notification_toke'];
}
