<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use App\Traits\BaseActions;
use App\Traits\HasMediaTrait;
use App\Traits\Filterable;
use App\Traits\Downloadable;

class Sponsor extends Model implements HasMedia
{
    use BaseActions;
    use HasMediaTrait;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'sponsors';
    protected $fillable = ['name', 'link', 'order', 'logo'];
    protected static $cacheKeys = ['sponsors'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')->orWhere('link', 'like', '%' . $search . '%');
        });
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

    // Helpers
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(75);
        $this->addMediaConversion('optimized')->width(400)->height(300);
    }
}
