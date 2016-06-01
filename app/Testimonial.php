<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';

    protected $guarded = ['id'];

    protected $dates = ['approved_at'];

    public static $validationRules=[
        'name'=>'required|max:255',
        'text'=>'required',
        'via'=>'required',
        'priority'=>'required|numeric'
    ];

    public static $validationMessages=[
        'name.required'=>'Ad boş bırakılamaz',
        'name.max'=>'Ad en fazla 255 karakter olabilir',
        'text.required'=>'Metin boş bırakılamaz',
        'priority.required'=>'Öncelik boş bırakılamaz',
        'priority.numeric'=>'Öncelik rakamlardan oluşmalıdır',
        'via.required'=>'Kaynak boş bırakılamaz',
    ];


    public function approver(){
        return $this->belongsTo('App\User', 'approved_by');
    }


}
