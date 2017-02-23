<?php

namespace App;

class PostImage extends BaseModel
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

}
