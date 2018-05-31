<?php

namespace App\Traits;

trait Mobile
{
    public function setMobileAttribute($mobile)
    {
        return $this->attributes['mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile), -10);
    }

    public function getMobileFormattedAttribute($mobile)
    {
        return '(' . substr($this->mobile, 0, 3) . ') ' . substr($this->mobile, 3, 3) . ' ' . substr($this->mobile, 6, 2) . ' ' . substr($this->mobile, 8, 2);
    }
}
