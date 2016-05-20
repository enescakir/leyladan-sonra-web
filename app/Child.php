<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Child extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'children';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    protected $dates = ['meeting_day', 'birthday', 'until'];


    protected $appends = ['full_name'];

    protected $casts = [
        'users' => 'string',
    ];

    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function processes(){
        return $this->hasMany('App\Process')->with(['user']);
    }


    public function getUserNameListAttribute(){
        return implode(", ",  $this->users->lists('full_name')->toArray());
    }

    public function getUserListAttribute(){
        return $this->users->lists('id');
    }

    public function getFullNameAttribute(){
        return $this->attributes['first_name'] . " " .$this->attributes['last_name'];
    }

    public function setMeetingDayAttribute($date){
        return $this->attributes['meeting_day'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function setBirthdayAttribute($date){
        return $this->attributes['birthday'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function setUntilAttribute($date){
        return $this->attributes['until'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }


    public function setGMobileAttribute($g_mobile){
        return $this->attributes['g_mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $g_mobile), -10);
    }

    public function getBirthdayHumanAttribute(){
        return date("d.m.Y", strtotime($this->attributes['birthday']));
    }


    public function getMeetingDayHumanAttribute(){
        return date("d.m.Y", strtotime($this->attributes['meeting_day']));
    }

    public function getUntilHumanAttribute(){
        return date("d.m.Y", strtotime($this->attributes['until']));
    }


}
