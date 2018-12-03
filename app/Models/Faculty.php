<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use Carbon\Carbon;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use App\Traits\HasMediaTrait;

class Faculty extends Model implements HasMedia
{
    use BaseActions;
    use Filterable;
    use HasMediaTrait;
    use Downloadable;

    // Properties
    protected $table = 'faculties';
    protected $fillable = [
        'name',
        'slug',
        'latitude',
        'longitude',
        'address',
        'city',
        'code',
        'started_at',
        'stopped_at'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'started_at', 'stopped_at'];

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

    public function managers()
    {
        return $this->hasMany(User::class)->role('manager');
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Child::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(Message::class, Chat::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    // Methods
    public static function toSelect($placeholder = null)
    {
        $result = static::orderBy('name')->pluck('name', 'id')->map(function ($name) {
            return "{$name} Tıp Fakültesi";
        });
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }

    public function toUsersSelect($placeholder = null)
    {
        $result = $this->users()->orderBy('first_name')->get(['id', 'faculty_id', 'first_name', 'last_name'])
                       ->pluck('full_name', 'id');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }

    // Scopes
    public function scopeStarted($query, $started = true)
    {
        return $started
            ? $query->whereNotNull('started_at')
            : $query->whereNull('started_at');
    }

    public function scopeSearch($query, $search)
    {
        if (is_null($search)) {
            return;
        }

        $query->where(function ($query2) use ($search) {
            $query2->where('faculties.name', 'like', "%{$search}%");
        });
    }

    // Mutators
    public function setStartedAtAttribute($date)
    {
        $this->attributes['started_at'] = $date
            ? Carbon::createFromFormat('d.m.Y', $date)->toDateString()
            : null;
    }

    public function setStoppedAtAttribute($date)
    {
        $this->attributes['stopped_at'] = $date
            ? Carbon::createFromFormat('d.m.Y', $date)->toDateString()
            : null;
    }

    // Accessors
    public function getStartedAtLabelAttribute()
    {
        return $this->attributes['started_at']
            ? Carbon::parse($this->attributes['started_at'])->format('d.m.Y')
            : null;
    }

    public function getStoppedAtLabelAttribute()
    {
        return $this->attributes['stopped_at']
            ? Carbon::parse($this->attributes['stopped_at'])->format('d.m.Y')
            : null;
    }

    public function getFullNameAttribute()
    {
        return "{$this->attributes['name']} Tıp Fakültesi";
    }

    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'optimized');
    }

    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'thumb');
    }

    public function isStarted()
    {
        return !is_null($this->started_at);
    }

    public function isStopped()
    {
        return !is_null($this->stopped_at);
    }

    // Helpers
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(75);
        $this->addMediaConversion('optimized')->width(320)->height(240);
    }
}
