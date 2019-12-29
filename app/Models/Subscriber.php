<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use BaseActions;

    // Properties
    protected $table = 'subscribers';
    protected $fillable = ['notification_toke'];
}
