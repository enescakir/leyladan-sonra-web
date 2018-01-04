<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Testimonial extends Model
{
    use Base;
    // Properties
    protected $table    = 'testimonials';
    protected $fillable = ['name', 'text', 'email', 'via', 'priority', 'approved_at', 'approved_by'];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'approved_at'];

    // Validation rules
    public static $validationRules = [
    'name'     =>'required|max:255',
    'text'     =>'required',
    'via'      =>'required',
    'priority' =>'required|numeric'
  ];

    // Relations
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
