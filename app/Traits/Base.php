<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Schema;
use Carbon\Carbon;
use Image;
use File;
use App\Models\User;
use App\Jobs\OptimizeImage;

trait Base
{
    use SoftDeletes;

    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    // protected $slugKeys = null;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                if (Auth::guard('web')->user()) {
                    $model->created_by = Auth::guard('web')->user()->id;
                }
            }
        });
        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                if (Auth::guard('web')->user()) {
                    $model->updated_by = Auth::guard('web')->user()->id;
                }
            }
        });
        static::deleting(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                if (Auth::guard('web')->user()) {
                    $model->deleted_by = Auth::guard('web')->user()->id;
                    $model->save();
                }
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : '';
    }

    public function getUpdatedAtHumanAttribute()
    {
        return $this->updated_at ? $this->updated_at->diffForHumans() : '';
    }

    public function getCreatedAtLabelAttribute()
    {
        return date('d.m.Y H:i', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtLabelAttribute()
    {
        return date('d.m.Y H:i', strtotime($this->attributes['updated_at']));
    }

    public function getPerPage()
    {
        return request('per_page', 25);
    }

    public function updateSlug()
    {
        return $this->slugKeys ?
        $this->update([
            'slug' => str_slug(remove_turkish(implode('-', array_map(function ($key) {
                return $this->attributes[$key];
            }, $this->slugKeys))))
        ])
        : false ;
    }

    public function scopeSlug($query, $slug)
    {
        $query->where('slug', $slug);
    }

    public static function findBySlug($slug)
    {
        return static::slug($slug)->firstOrFail();
    }

    public static function clearCaches()
    {
        if (self::$cacheKeys) {
            foreach (self::$cacheKeys as $key) {
                cache()->forget($key);
            }
            return true;
        }
        return false;
    }

    // public function uploadImage($file, $attribute, $location, $size = 1000, $quality = 80, $format = "jpg", $resize = true)
    // {
    //     $imageName = $this->attributes['id'] . str_random(5) . "." . $format ;
    //     $imageLocation = upload_path($location);
    //     $this->attributes[$attribute] = $imageName;
    //     if ($resize) {
    //         Image::make($file)
    //         ->resize($size, null, function ($constraint) {
    //             $constraint->aspectRatio();
    //         })
    //         ->save($imageLocation . '/' . $imageName, $quality);
    //     } else {
    //         Image::make($file)
    //         ->save($imageLocation . '/' . $imageName, $quality);
    //     }
    //     dispatch(new OptimizeImage($imageLocation . '/' . $imageName));
    //     return $this->save();
    // }
    public function uploadMedia($file, $collection = 'default')
    {
        $this->addMedia($file)->sanitizingFileName(function ($fileName) {
            return $this->id . str_random(5) . '.' . explode('.', $fileName)[1];
        })->toMediaCollection($collection);
    }

    public function deleteImage($attribute, $location, $null = false)
    {
        $imageLocation = upload_path($location) . '/' . $this->$attribute;
        File::delete($imageLocation);
        if ($null) {
            $this->$attribute = null;
        }
        return $this->save();
    }
}
