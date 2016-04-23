<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $appends = ['full_name'];

    public function getFullNameAttribute(){
        return $this->attributes['first_name'] . " " .$this->attributes['last_name'];
    }
}
