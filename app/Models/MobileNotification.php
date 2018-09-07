<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;

class MobileNotification extends Model
{
    use BaseActions;
    // Properties
    protected $table = 'mobile_notifications';
    protected $fillable = ['message', 'expected_at', 'sent_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'expected_at', 'sent_at'];
}
