<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;
use App\Traits\Base;
use Excel;

class Sponsor extends Model implements HasMedia
{
    use Base;
    use HasMediaTrait;

    // Properties
    protected $table = 'sponsors';
    protected $fillable = ['name', 'link', 'order', 'logo'];
    protected static $cacheKeys = [
        'sponsors'
    ];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('link', 'like', '%' . $search . '%');
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

    // Global Methods
    public static function download($sponsors)
    {
        $sponsors = $sponsors->get(['id', 'name', 'link', 'logo', 'created_at']);
        Excel::create('LS_Destekciler_' . date('d_m_Y'), function ($excel) use ($sponsors) {
            $sponsors = $sponsors->each(function ($item, $key) {
                $item->logo = $item->logo_url;
            });
            $excel->sheet('Destekciler', function ($sheet) use ($sponsors) {
                $sheet->fromArray($sponsors, null, 'A1', true);
            });
        })->download('xlsx');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(75);
        $this->addMediaConversion('optimized')->width(400)->height(300);
    }
}
