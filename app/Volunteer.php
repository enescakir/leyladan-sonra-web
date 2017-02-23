<?php

namespace App;

use App\Traits\Mobile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{
    use SoftDeletes;
    use Mobile;

    protected $table = 'volunteers';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = Auth::user()->id;
            }
        });

        static::deleting(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                $model->deleted_by = Auth::user()->id;
                $model->save();
            }
        });
    }

    public function boughtGift(){
        return $this->hasMany('App\Child');
    }

    public function volunteeredGift(){
        return $this->hasMany('App\Chat');
    }

    public function setMobileAttribute($mobile){
        return $this->attributes['mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile), -10);
    }
}