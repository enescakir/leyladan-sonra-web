<?php

namespace App;

class Feed extends BaseModel
{
    protected $table = 'feeds';
    protected $guarded = [];

    public function faculty()
    {
        return $this->belongsTo('App\Faculty');
    }

    public function getIconAttribute()
    {
        $icon = $this->attributes['icon'];
        $iconText = "";
        switch ($icon) {
            case "1":
                $iconText = '<div class="label label-sm label-warning"> <i class="fa fa-child"></i></div>';
                break;
            case "2":
                $iconText = '<div class="label label-sm label-info"> <i class="fa fa-male"></i></div>';
                break;
            case "3":
                $iconText = '<div class="label label-sm label-success"> <i class="fa fa-gift"></i></div>';
                break;
            case "4":
                $iconText = '<div class="label label-sm label-danger"> <i class="fa fa-trash"></i></div>';
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }

        return $iconText;
    }
}