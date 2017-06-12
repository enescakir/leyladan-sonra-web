<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth, Schema, Carbon\Carbon;

class BaseModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        // create a event to happen on updating
        static::updating(function ($model) {
            if(Schema::hasColumn($model->getTable(), 'updated_by')) {
              if(Auth::user()){
                $model->updated_by = Auth::user()->id;
              }
            }
        });

        // create a event to happen on deleting
        static::deleting(function ($model) {
            if(Schema::hasColumn($model->getTable(), 'deleted_by')) {
              if(Auth::user()){
                $model->deleted_by = Auth::user()->id;
                $model->save();
              }
            }
        });

        // create a event to happen on saving
        static::creating(function ($model) {
            if(Schema::hasColumn($model->getTable(), 'created_by')) {
              if(Auth::user()){
                $model->created_by = Auth::user()->id;
              }
            }
        });

    }

    public function creator(){
        return $this->belongsTo('App\User', 'created_by');
    }

    public function getCreatedAtHumanAttribute(){
        Carbon::setLocale('tr');
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']),'Europe/Istanbul')->diffForHumans();
    }

    public function getUpdatedAtHumanAttribute(){
        Carbon::setLocale('tr');
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']),'Europe/Istanbul')->diffForHumans();
    }

    public function getCreatedAtLabelAttribute(){
        if($this->attributes['created_at'] == null){
            return '';
        }
        return date("d.m.Y", strtotime($this->attributes['created_at']));
    }
}
