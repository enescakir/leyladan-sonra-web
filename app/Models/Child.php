<?php

namespace App\Models;

use App\Traits\Birthday;
use Carbon\Carbon;

use App\Enums\PostType;
use App\Enums\ChatStatus;

class Child extends BaseModel
{
  use Birthday;
  // Properties
  protected $table    = 'children';
  protected $fillable = [
    'faculty_id', 'department', 'first_name', 'last_name', 'diagnosis',
    'diagnosis_desc', 'taken_treatment', 'child_state', 'child_state_desc',
    'gender', 'meeting_day', 'birthday', 'wish', 'g_first_name', 'g_last_name',
    'g_mobile', 'g_email', 'province', 'city', 'address', 'extra_info',
    'volunteer_id', 'verification_doc', 'gift_state', 'on_hospital', 'until', 'slug'
  ];
  protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'meeting_day', 'birthday', 'until'];
  protected $appends  = ['full_name'];
  protected $slugKeys = ['first_name', 'id'];

  // Relations
  public function users()
  {
    return $this->belongsToMany(User::class)->withTimestamps();
  }

  public function faculty()
  {
    return $this->belongsTo(Faculty::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function meetingPosts()
  {
    return $this->hasMany(Post::class)->where('type', PostType::Meeting);
  }

  public function chats()
  {
    return $this->hasMany(Chat::class);
  }

  public function openChats()
  {
    return $this->hasMany(Chat::class)->whereIn('status', [ChatStatus::Open, ChatStatus::Answered]);
  }

  public function unansweredMessages()
  {
    return $this->hasManyThrough(Message::class, Chat::class)->whereNull('answered_at');
  }

  public function processes()
  {
    return $this->hasMany(Process::class)->with(['creator']);
  }

  // Accessors
  public function getUserNameListAttribute()
  {
    return implode(", ", $this->users->pluck('full_name')->toArray());
  }

  public function getUserListAttribute()
  {
    return $this->users->pluck('id');
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

  // Mutators
  public function setGMobileAttribute($g_mobile)
  {
    return $this->attributes['g_mobile'] = make_mobile($g_mobile);
  }
}
