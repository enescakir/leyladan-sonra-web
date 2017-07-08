<?php

namespace App\Traits;

trait Mobile
{
  public function setMobileAttribute($mobile)
  {
    return $this->attributes['mobile'] = make_mobile($mobile);
  }
}
