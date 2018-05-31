<?php

namespace App\Traits;

use Carbon\Carbon;

trait Birthday
{
    public function setBirthdayAttribute($date)
    {
        return $this->attributes['birthday'] = Carbon::parse($date)->toDateString();
    }

    public function getBirthdayLabelAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->parse('d.m.Y');
    }
}
