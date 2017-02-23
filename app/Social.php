<?php

namespace App;

class Social extends BaseModel
{
    protected $table = 'socials';

    public function child()
    {
        return $this->belongsTo('App\Child');
    }

    public function facebook()
    {
        return $this->belongsTo('App\User', 'facebook_by');
    }

    public function twitter()
    {
        return $this->belongsTo('App\User', 'twitter_by');
    }

    public function instagram()
    {
        return $this->belongsTo('App\User', 'instagram_by');
    }


    public function getFacebookAtAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['facebook_at']));
    }

    public function getTwitterAtAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['twitter_at']));
    }

    public function getInstagramAtAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['instagram_at']));
    }
}