<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';

    protected $guarded = [];

    protected $dates = ['approved_at'];


    public function approver(){
        return $this->belongsTo('App\User', 'approved_by');
    }


}
