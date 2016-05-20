<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    protected $table = 'chats';

    protected $guarded = [];

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function child(){
        return $this->belongsTo('App\Child');
    }

    public function volunteer(){
        return $this->belongsTo('App\Volunteer');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

}
