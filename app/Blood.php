<?php

namespace App;

use App\Traits\Mobile;

class Blood extends BaseModel
{
    use Mobile;
    protected $fillable = [ 'rh', 'mobile', 'city', 'blood_type' ];

    public static $validationRules=[
        'rh'=>'required',
        'mobile'=>'required|unique:bloods|max:255',
        'city'=>'required|max:255',
        'blood_type'=>'required',
    ];

    public static $validationMessages=[
        'rh.required'=>'RH boş bırakılamaz',
        'mobile.required'=>'Telefon numarası boş bırakılamaz',
        'mobile.unique'=>'Bu telefon numarası zaten kayıtlı.',
        'mobile.max'=>'Telefon numarası en fazla 255 karakter olabilir',
        'city.required'=>'Şehir boş bırakılamaz',
        'city.max'=>'Şehir en fazla 255 karakter olabilir',
        'blood_type.required'=>'Kan grubu boş bırakılamaz',
    ];
}
