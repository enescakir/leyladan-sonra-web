<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasBirthday
{
    public function setBirthdayAttribute($date)
    {
        return $this->attributes['birthday'] = Carbon::parse($date)->toDateString();
    }

    public function getBirthdayLabelAttribute()
    {
        return $this->attributes['birthday']
        ? Carbon::parse($this->attributes['birthday'])->format('d.m.Y')
        : '';
    }
}
