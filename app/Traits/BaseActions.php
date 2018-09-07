<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Schema;
use App\Models\User;

trait BaseActions
{
    use SoftDeletes;

    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    // protected $slugKeys = null;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                if (Auth::check()) {
                    $model->created_by = Auth::user()->id;
                }
            }
        });
        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                if (Auth::check()) {
                    $model->updated_by = Auth::user()->id;
                }
            }
        });
        static::deleting(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                if (Auth::check()) {
                    $model->deleted_by = Auth::user()->id;
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

    public function getDates()
    {
        $defaults = ['created_at', 'updated_at', 'deleted_at'];

        return array_unique(array_merge($this->dates, $defaults));
    }
}
