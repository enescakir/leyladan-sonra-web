<?php

namespace App\Traits;

trait HasMobile
{
    public function setMobileAttribute($mobile)
    {
        return $this->attributes['mobile'] = substr(
            str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile),
            -10
        );
    }

    public function getMobileFormattedAttribute()
    {
        return '(' . substr($this->mobile, 0, 3) . ') ' . substr($this->mobile, 3, 3) . ' ' . substr(
            $this->mobile,
            6,
                2
        ) . ' ' . substr($this->mobile, 8, 2);
    }
}
