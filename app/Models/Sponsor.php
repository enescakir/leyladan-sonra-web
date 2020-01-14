<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Filterable;
use EnesCakir\Helper\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Sponsor extends Model implements HasMedia
{
    use BaseActions;
    use HasMediaTrait;
    use Filterable;

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
        $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 100, 75);
        $this->addMediaConversion('optimized')->fit(Manipulations::FIT_CROP, 400, 300);
    }
}
