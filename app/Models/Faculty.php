<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

use Carbon\Carbon;

class Faculty extends Model
{
    use Base;
    // Properties
    protected $table    = 'faculties';
    protected $fillable = [
    'full_name', 'slug', 'latitude', 'longitude', 'address',
    'city', 'code', 'started_at'
  ];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'started_at'];

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

    public static function toSelect($empty = false)
    {
        $res = Faculty::orderBy('full_name')->pluck('full_name', 'id')->map(function ($name) {
            return $name . ' Tıp Fakültesi';
        });
        return $empty ? collect(['' => ''])->merge($res) : $res;
    }

    // Scopes
    public function scopeStarted($query)
    {
        $query->whereNotNull('started_at');
    }

    // Mutators
    public function setStartedAtAttribute($date)
    {
        $this->attributes['started_at'] = $date ? null : Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    // Accessors
    public function getStartedAtLabelAttribute()
    {
        return $this->attributes['started_at'] ? null : date("d.m.Y", strtotime($this->attributes['started_at']));
    }
}
