<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $validationRules=[
        'title'=>'required|max:255',
        'category'=>'required',
        'thumb'=>'image',
        'type'=>'required',
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


    public function categories(){
        return $this->belongsToMany('App\BlogCategory')->withTimestamps();
    }

    public function author(){
        return $this->belongsTo('App\User', 'author_id');
    }

    public function setTextAttribute($text){
        return $this->attributes['text'] = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', strip_tags($text, '<p><a><br><pre><i><b><u><ul><li><ol><blockquote><h1><h2><h3><h4><h5>'));
    }




}
