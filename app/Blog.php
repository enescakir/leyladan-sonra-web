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


    public function categories(){
        return $this->belongsToMany('App\BlogCategory')->withTimestamps();
    }

    public function author(){
        return $this->belongsTo('App\User', 'author_id');
    }

}
