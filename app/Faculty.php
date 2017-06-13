<?php

namespace App;

use Carbon\Carbon;

class Faculty extends BaseModel
{
    protected $table = 'faculties';
    protected $guarded = [];

    public function feeds()
    {
        return $this->hasMany('App\Feed');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function usersToSelect($empty = false)
    {
      $res = $this->users()->orderby('first_name')->get()->pluck('fullname', 'id');
      return $empty ? array_merge($res, ['' => '']) : $res;
    }

    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function responsibles()
    {
        return $this->hasMany('App\User')->where('title', 'Fakülte Sorumlusu');
    }

    public function posts()
    {
        return $this->hasManyThrough('App\Post', 'App\Child');
    }

    public function children()
    {
        return $this->hasMany('App\Child');
    }

    public static $validationRules=[
        'full_name'=>'required|max:255',
        'slug'=>'required|max:255',
        'latitude'=>'numeric',
        'longitude'=>'numeric',
        'city'=>'required|max:255'
    ];

    public static $validationMessages=[
        'full_name.required'=>'Ad boş bırakılamaz',
        'full_name.max'=>'Ad en fazla 255 karakter olabilir',
        'slug.required'=>'Kısa ad boş bırakılamaz',
        'slug.max'=>'Kısa ad en fazla 255 karakter olabilir',
        'latitude.numeric'=>'Enlem sayılardan oluşmalıdır',
        'longitude.numeric'=>'Boylam sayılardan oluşmalıdır',
        'city.required'=>'Şehir boş bırakılamaz',
        'city.max'=>'Şehir en fazla 255 karakter olabilir'
    ];


    public function setStartedAtAttribute($date)
    {
        if ($date == '') {
            return $this->attributes['started_at'] = null;
        };

        $this->attributes['started_at'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function getStartedAtLabelAttribute()
    {
        if ($this->attributes['started_at'] == null) {
            return null;
        };

        return date("d.m.Y", strtotime($this->attributes['started_at']));
    }
}
