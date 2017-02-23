<?php

namespace App;

class MobileNotification extends BaseModel
{
    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'expected_at', 'sent_at'];
}
