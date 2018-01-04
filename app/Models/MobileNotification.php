<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class MobileNotification extends BaseModel
{
    use Base;
    // Properties
    protected $table    = 'mobile_notifications';
    protected $fillable = ['message', 'expected_at', 'sent_at'];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'expected_at', 'sent_at'];
}
