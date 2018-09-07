<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;

class Subscriber extends Model
{
    use BaseActions;
    // Properties
    protected $table    = 'subscribers';
    protected $fillable = ['notification_toke'];
}
