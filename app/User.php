<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\ActivateEmail as ActivateEmailNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Birthday;
use App\Traits\Mobile;
use Auth;

class User extends Authenticatable
{
    use Birthday, Mobile;
    use SoftDeletes;
    use Notifiable;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'birthday', 'mobile', 'year', 'title', 'profile_photo', 'faculty_id', 'gender'];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['full_name'];

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
    }

    public function children()
    {
        return $this->belongsToMany('App\Child');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Faculty');
    }

    public function processes()
    {
        return $this->hasMany('App\Process', 'created_by');
    }

    public function answers()
    {
        return $this->hasMany('App\Message', 'answered_by');
    }

    public function visits()
    {
        return $this->hasMany('App\Process', 'created_by')->where('desc', 'Ziyaret edildi.');
    }

    public function scopeTitle($query, $title)
    {
        $query->where('title', $title);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . " " . $this->attributes['last_name'];
    }


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
