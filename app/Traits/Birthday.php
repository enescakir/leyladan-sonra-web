<?php

namespace App\Traits;

use Carbon\Carbon;

trait Birthday
{
  public function setBirthdayAttribute($date)
  {
    return $this->attributes['birthday'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
  }

  public function getBirthdayLabelAttribute()
  {
    return date("d.m.Y", strtotime($this->attributes['birthday']));
  }
}
