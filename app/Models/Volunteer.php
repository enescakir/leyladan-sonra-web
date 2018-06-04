<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Base;
use App\Traits\Mobile;

class Volunteer extends Model
{
    use Base;
    use Mobile;

    // Properties
    protected $table = 'volunteers';
    protected $fillable = [
    'first_name', 'last_name', 'email', 'mobile', 'city',
    'platform', 'notification_token', 'player_id', 'device_token'
  ];
    protected $appends = ['full_name'];

    // Relations
    public function boughtGift()
    {
        return $this->hasMany(Child::class);
    }

    public function volunteeredGift()
    {
        return $this->hasMany(Chat::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }
}
