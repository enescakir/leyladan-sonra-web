<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;
use App\Traits\Mobile;

class Blood extends Model
{
    use Base;
    use Mobile;

    // Properties
    protected $table    = 'bloods';
    protected $fillable = ['rh', 'mobile', 'city', 'blood_type'];
}
