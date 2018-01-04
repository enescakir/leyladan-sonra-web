<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class EmailSample extends Model
{
    use Base;
    // Properties
    protected $table    = 'email_samples';
    protected $fillable = ['name', 'category', 'text'];
}
