<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'processes';

    public function child(){
        return $this->belongsTo('App\Child');
    }

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function getCreatedAtAttribute($date){
        return date("d.m.Y", strtotime($this->attributes['created_at']));
    }

}
