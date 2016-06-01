<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Faculty extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faculties';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function feeds(){
        return $this->hasMany('App\Feed');
    }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function chats(){
        return $this->hasMany('App\Chat');
    }

    public function responsibles(){
        return $this->hasMany('App\User')->where('title','Fakülte Sorumlusu');
    }

    public function posts(){
        return $this->hasManyThrough('App\Post', 'App\Child');
    }


    public static $validationRules=[
        'full_name'=>'required|max:255',
        'slug'=>'required|max:255',
        'latitude'=>'numeric',
        'longitude'=>'numeric',
        'city'=>'required|max:255'
    ];

    public static $validationMessages=[
        'full_name.required'=>'Ad boş bırakılamaz',
        'full_name.max'=>'Ad en fazla 255 karakter olabilir',
        'slug.required'=>'Kısa ad boş bırakılamaz',
        'slug.max'=>'Kısa ad en fazla 255 karakter olabilir',
        'latitude.numeric'=>'Enlem sayılardan oluşmalıdır',
        'longitude.numeric'=>'Boylam sayılardan oluşmalıdır',
        'city.required'=>'Şehir boş bırakılamaz',
        'city.max'=>'Şehir en fazla 255 karakter olabilir'
    ];


    public function setStartedAtAttribute($date){
        if($date == ''){
            return $this->attributes['started_at'] = null;
        };

        $this->attributes['started_at'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

//    public function getStartedAtAttribute(){
//        return date("d.m.Y", strtotime($this->attributes['started_at']));
//    }

}
