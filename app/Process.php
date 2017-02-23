<?php

namespace App;

class Process extends BaseModel
{
    protected $table = 'processes';

    public function child()
    {
        return $this->belongsTo('App\Child');
    }
}
