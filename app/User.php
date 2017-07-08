<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\ActivateEmail as ActivateEmailNotification;

use App\Scopes\GraduateScope;
use App\Scopes\LeftScope;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Birthday;
use App\Traits\Mobile;
use Auth;

class User extends Authenticatable
{
  use Birthday, Mobile;
  use SoftDeletes;
  use Notifiable;

  // Properties
  protected $table    = 'users';
  protected $fillable = [
    'first_name', 'last_name', 'email', 'password', 'birthday', 'mobile',
    'year', 'title', 'profile_photo', 'faculty_id', 'gender', 'email_token',
    'left_at', 'graduated_at'
  ];
  protected $hidden   = ['password', 'remember_token'];
  protected $appends  = ['full_name'];
  protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'birthday', 'left_at', 'graduated_at'];

  public static function boot()
  {
    parent::boot();
    static::updating(function ($model) {
      if(Auth::user()) $model->updated_by = Auth::user()->id;
    });

    static::deleting(function ($model) {
      if(Auth::user()) $model->deleted_by = Auth::user()->id;
    });

    static::creating(function ($model) {
      if(Auth::user()) $model->created_by = Auth::user()->id;
    });

    static::addGlobalScope(new GraduateScope);
    static::addGlobalScope(new LeftScope);
  }

  // Relations
  public function children()
  {
    return $this->belongsToMany(Child::class);
  }

  public function faculty()
  {
    return $this->belongsTo(Faculty::class);
  }

  public function processes()
  {
    return $this->hasMany(Process::class, 'created_by');
  }

  public function answers()
  {
    return $this->hasMany(Message::class, 'answered_by');
  }

  public function visits()
  {
    return $this->hasMany(Process::class, 'created_by')->where('desc', ProcessType::Visit);
  }

  // Scopes
  public function scopeTitle($query, $title)
  {
    $query->where('title', $title);
  }

  // Accessors
  public function getFullNameAttribute()
  {
    return $this->attributes['first_name'] . " " . $this->attributes['last_name'];
  }

  // Notifications
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPasswordNotification($token));
  }

  public function sendEmailActivationNotification()
  {
    $token = hash_hmac('sha256', str_random(40), $this->email);
    $this->email_token = $token;
    $this->save();
    $this->notify(new ActivateEmailNotification($token));
  }
}
