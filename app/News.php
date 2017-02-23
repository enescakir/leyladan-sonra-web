<?php

namespace App;

class News extends BaseModel
{
    protected $table = 'news';

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

}
