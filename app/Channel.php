<?php

namespace App;

class Channel extends BaseModel
{
    public function news()
    {
        return $this->hasMany('App\News');
    }

}
