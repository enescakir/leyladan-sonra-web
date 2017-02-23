<?php

namespace App;

use App\Traits\Birthday;
use Carbon\Carbon;

class Child extends BaseModel
{
    use Birthday;

    protected $table = 'children';
    protected $guarded = ['id'];
    protected $dates = ['meeting_day', 'birthday', 'until', 'deleted_at', 'created_at', 'updated_at'];
    protected $appends = ['full_name'];
    protected $casts = ['users' => 'string',];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function faculty()
    {
        return $this->belongsTo('App\Faculty');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function meetingPosts()
    {
        return $this->hasMany('App\Post')->where('type', 'Tanışma');
    }

    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function openChats()
    {
        return $this->hasMany('App\Chat')->whereIn('status', ['Açık', 'Cevaplandı']);
    }

    public function unansweredMessages()
    {
        return $this->hasManyThrough('App\Message', 'App\Chat')->whereNull('answered_at');
    }

    public function processes()
    {
        return $this->hasMany('App\Process')->with(['creator']);
    }


    public function getUserNameListAttribute()
    {
        return implode(", ", $this->users->lists('full_name')->toArray());
    }

    public function getUserListAttribute()
    {
        return $this->users->lists('id');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . " " . $this->attributes['last_name'];
    }

    public function getMeetingDayHumanAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['meeting_day']));
    }

    public function getUntilHumanAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['until']));
    }

    public function setMeetingDayAttribute($date)
    {
        return $this->attributes['meeting_day'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function setUntilAttribute($date)
    {
        return $this->attributes['until'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function setGMobileAttribute($g_mobile)
    {
        return $this->attributes['g_mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $g_mobile), -10);
    }
}
