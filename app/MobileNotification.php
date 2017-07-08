<?php

namespace App;

class MobileNotification extends BaseModel
{
  // Properties
  protected $table    = 'mobile_notifications';
  protected $fillable = ['message', 'expected_at', 'sent_at'];
  protected $dates    = array_merge($this->dates, ['expected_at', 'sent_at']);
}
