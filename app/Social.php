<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'socials';

    public function child(){
        return $this->belongsTo('App\Child');
    }

    public function creator(){
        return $this->belongsTo('App\User', 'created_by');
    }

    public function facebook(){
        return $this->belongsTo('App\User', 'facebook_by');
    }

    public function twitter(){
        return $this->belongsTo('App\User', 'twitter_by');
    }

    public function instagram(){
        return $this->belongsTo('App\User', 'instagram_by');
    }


    public function getFacebookAtAttribute($date){
        return date("d.m.Y", strtotime($this->attributes['facebook_at']));
    }

    public function getTwitterAtAttribute($date){
        return date("d.m.Y", strtotime($this->attributes['twitter_at']));
    }

    public function getInstagramAtAttribute($date){
        return date("d.m.Y", strtotime($this->attributes['instagram_at']));
    }

}
