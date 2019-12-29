<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Filterable;
use EnesCakir\Helper\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Material extends Model implements HasMedia
{
    use BaseActions;
    use HasMediaTrait;
    use Filterable;

    // Properties
    protected $table = 'materials';
    protected $fillable = [
        'name', 'category', 'link'
    ];

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'optimized');
    }

    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'thumb');
    }

    // Scopes
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%');
        });
    }

    // Helpers
    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(100);
        $this->addMediaConversion('optimized')->width(300)->height(300);
    }
}
