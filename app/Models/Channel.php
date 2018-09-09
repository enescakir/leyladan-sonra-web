<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use App\Traits\BaseActions;
use App\Traits\HasMediaTrait;
use App\Traits\Filterable;
use App\Traits\Downloadable;

class Channel extends Model implements HasMedia
{
    use BaseActions;
    use HasMediaTrait;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'channels';
    protected $fillable = ['name', 'logo', 'category'];

    // Relations
    public function news()
    {
        return $this->hasMany(News::class);
    }

    // Accessors
    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'optimized');
    }

    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'thumb');
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')->orWhere('channel', 'like', '%' . $search . '%');
        });
    }

    // Helpers
    public static function toSelect($placeholder = null)
    {
        $result = Channel::orderBy('name')->pluck('name', 'id');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }

    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(75);
        $this->addMediaConversion('optimized')->width(400)->height(300);
    }
}
