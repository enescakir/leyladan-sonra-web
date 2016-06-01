<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    public function channel(){
        return $this->belongsTo('App\Channel');
    }

}
