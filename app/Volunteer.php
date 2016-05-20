<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $table = 'volunteers';

    protected $guarded = [];

    public function setMobileAttribute($mobile){
        return $this->attributes['mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile), -10);
    }

}
