<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;
use App\Traits\Base;

class Material extends Model implements HasMedia
{
    use Base;
    use HasMediaTrait;

    // Properties
    protected $table = 'materials';
    protected $fillable = [
        'name', 'category', 'link'
    ];

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'optimized');
    }

    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'thumb');
    }

    // Helpers
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                        ->orWhere('link', 'like', '%' . $search . '%');
        });
    }

    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(100);
        $this->addMediaConversion('optimized')->width(300)->height(300);
    }
}
