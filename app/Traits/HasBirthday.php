<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasBirthday
{

    public function setBirthdayAttribute($date)
    {
        $this->attributes['birthday'] = $date
            ? Carbon::createFromFormat('d.m.Y', $date)->toDateString()
            : null;
    }

    public function getBirthdayLabelAttribute()
    {
        return $this->attributes['birthday']
        ? Carbon::parse($this->attributes['birthday'])->format('d.m.Y')
        : '';
    }
}
