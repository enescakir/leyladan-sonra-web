<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Faculty extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public static $validationRules=[
        'full_name'=>'required|max:255',
        'short_name'=>'required|max:255',
        'latitude'=>'numeric',
        'longitude'=>'numeric',
        'city'=>'required|max:255'
    ];

    public static $validationMessages=[
        'full_name.required'=>'Ad boş bırakılamaz',
        'full_name.max'=>'Ad en fazla 255 karakter olabilir',
        'short_name.required'=>'Kısa ad boş bırakılamaz',
        'short_name.max'=>'Kısa ad en fazla 255 karakter olabilir',
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

}
