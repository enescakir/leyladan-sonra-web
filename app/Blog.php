<?php

namespace App;

class Blog extends BaseModel
{

    protected $table = 'blogs';
    protected $guarded = [];

    public static $validationRules=[
        'title'=>'required|max:255',
        'categories'=>'required',
        'thumb'=>'image',
        'type'=>'required',
    ];

    public static $validationMessages=[
        'title.required'=>'Başlık boş bırakılamaz.',
        'title.max'=>'Başlık en fazla 255 karakter olabilir.',
        'categories.required'=>'Kategori boş bırakılamaz.',
        'thumb.image'=>'Öne çıkarılan resmi geçerli formatta seçiniz.',
        'type.required'=>'Tip boş bırakılamaz.'
    ];


    public function categories(){
        return $this->belongsToMany('App\BlogCategory','blog_category','blog_id', 'category_id')->withTimestamps();
    }

    public function author(){
        return $this->belongsTo('App\User', 'author_id');
    }

    public function setTextAttribute($text){
        return $this->attributes['text'] = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', strip_tags($text, '<p><a><br><pre><i><b><u><ul><li><ol><img><blockquote><h1><h2><h3><h4><h5>'));
    }




}
