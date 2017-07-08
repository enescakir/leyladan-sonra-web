<?php

namespace App;

class MobileNotification extends BaseModel
{
  // Properties
  protected $table    = 'mobile_notifications';
  protected $fillable = ['message', 'expected_at', 'sent_at'];
  protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'expected_at', 'sent_at'];

}
