<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;
use App\Traits\Base;
use Excel;

class Channel extends Model implements HasMedia
{
    use Base;
    use HasMediaTrait;

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
            $query2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('channel', 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function download($channels)
    {
        $channels = $channels->get(['id', 'name', 'category', 'logo', 'created_at']);
        Excel::create('LS_HaberKanallari_' . date('d_m_Y'), function ($excel) use ($channels) {
            $channels = $channels->each(function ($item, $key) {
                $item->logo = $item->logo_url;
            });
            $excel->sheet('Kanallar', function ($sheet) use ($channels) {
                $sheet->fromArray($channels, null, 'A1', true);
            });
        })->download('xlsx');
    }

    public static function toSelect($empty = false)
    {
        $res = Channel::orderBy('name')->pluck('name', 'id');
        return $empty ? collect(['' => ''])->merge($res) : $res;
    }

    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(100)->height(75);
        $this->addMediaConversion('optimized')->width(400)->height(300);
    }
}
