<?php

namespace App;

use Carbon\Carbon;

class Faculty extends BaseModel
{
  // Properties
  protected $table    = 'faculties';
  protected $fillable = [
    'full_name', 'slug', 'latitude', 'longitude', 'address',
    'city', 'code', 'started_at'
  ];
  protected $dates    = array_merge($this->dates, ['started_at']);

  // Validation rules
  public static $createRules = [
    'full_name' =>'required|max:255',
    'slug'      =>'required|max:255',
    'latitude'  =>'numeric',
    'longitude' =>'numeric',
    'city'      =>'required|max:255'
  ];

  // Relations
  public function feeds()
  {
    return $this->hasMany(Feed::class);
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }

  public function chats()
  {
    return $this->hasMany(Chat::class);
  }

  public function responsibles()
  {
    return $this->hasMany(User::class)->where('title', 'Fakülte Sorumlusu');
  }

  public function posts()
  {
    return $this->hasManyThrough(Post::class, Child::class);
  }

  public function children()
  {
    return $this->hasMany(Child::class);
  }

  // Methods
  public function usersToSelect($empty = false)
  {
    $res = $this->users()->orderby('first_name')->get()->pluck('fullname', 'id');
    return $empty ? array_merge($res, ['' => '']) : $res;
  }

  // Mutators
  public function setStartedAtAttribute($date)
  {
    $this->attributes['started_at'] = $date ? NULL : Carbon::createFromFormat('d.m.Y', $date)->toDateString();
  }

  // Accessors
  public function getStartedAtLabelAttribute()
  {
    return $this->attributes['started_at'] ? NULL : date("d.m.Y", strtotime($this->attributes['started_at']));
  }
}
