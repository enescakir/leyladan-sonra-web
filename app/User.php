<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'birthday', 'mobile', 'year', 'title', 'profile_photo', 'faculty_id', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['full_name'];


    public function children(){
        return $this->belongsToMany('App\Child');
    }

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function processes(){
        return $this->hasMany('App\Process', 'creator_id');
    }

    public function answers(){
        return $this->hasMany('App\Message', 'answered_by');
    }

    public function visits(){
        return $this->hasMany('App\Process', 'creator_id')->where('desc', 'Ziyaret edildi.');
    }

    public function setBirthdayAttribute($date){
        return $this->attributes['birthday'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function setMobileAttribute($mobile){
        return $this->attributes['mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile), -10);
    }

    public function getFullNameAttribute(){
        return $this->attributes['first_name'] . " " .$this->attributes['last_name'];
    }

    public function getBirthdayHumanAttribute(){
        return date("d.m.Y", strtotime($this->attributes['birthday']));
    }

}
