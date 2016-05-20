<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Blood extends Model
{

    protected $fillable = [
        'first_name', 'last_name', 'gender', 'rh', 'height', 'weight', 'birthday', 'mobile', 'city', 'blood_type', 'email'
    ];

    public static $validationRules=[
        'first_name'=>'required|max:255',
        'last_name'=>'required|max:255',
        'gender'=>'required',
        'rh'=>'required',
        'birthday'=>'required|max:255',
        'mobile'=>'required|unique:bloods|max:255',
        'city'=>'required|max:255',
        'blood_type'=>'required',
        'email'=>'required|email|max:255'
    ];

    public static $validationMessages=[
        'first_name.required'=>'İsim boş bırakılamaz',
        'first_name.max'=>'İsim en fazla 255 karakter olabilir',
        'last_name.required'=>'Soyad boş bırakılamaz',
        'last_name.max'=>'Soyad en fazla 255 karakter olabilir',
        'gender.required'=>'Cinsiyet boş bırakılamaz',
        'rh.required'=>'RH boş bırakılamaz',
        'birthday.required'=>'Doğum günü boş bırakılamaz',
        'birthday.max'=>'Doğum günü en fazla 255 karakter olabilir',
        'mobile.required'=>'Telefon numarası boş bırakılamaz',
        'mobile.unique'=>'Bu telefon numarası zaten kayıtlı.',
        'mobile.max'=>'Telefon numarası en fazla 255 karakter olabilir',
        'city.required'=>'Şehir boş bırakılamaz',
        'city.max'=>'Şehir en fazla 255 karakter olabilir',
        'blood_type.required'=>'Kan grubu boş bırakılamaz',
        'email.required'=>'E-posta adresi boş bırakılamaz',
        'email.max'=>'E-posta en fazla 255 karakterden oluşabilir',
        'email.email'=>'Lütfen geçerli bir e-posta adresi giriniz'
    ];

    public function setBirthdayAttribute($date){
        return $this->attributes['birthday'] = Carbon::createFromFormat('d.m.Y', $date)->toDateString();
    }

    public function setMobileAttribute($mobile){
        return $this->attributes['mobile'] = substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile), -10);
    }

}
