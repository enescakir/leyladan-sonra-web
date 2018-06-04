<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Base;
use App\Traits\Approval;
use Excel;

class Testimonial extends Model
{
    use Base;
    use Approval;

    // Properties
    protected $table = 'testimonials';
    protected $fillable = ['name', 'text', 'email', 'via', 'priority', 'approved_at', 'approved_by'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'approved_at'];

    // Validation rules
    public static $rules = [
        'name'     => 'required|max:255',
        'text'     => 'required',
        'via'      => 'required',
        'priority' => 'required|numeric'
    ];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) {
            $query2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('text', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function toSourceSelect($placeholder = null)
    {
        $result = static::orderBy('via')->pluck('via', 'via');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }

    public static function download($testimonials)
    {
        $testimonials = $testimonials->get();
        Excel::create('LS_Referanslar_' . date('d_m_Y'), function ($excel) use ($testimonials) {
            $excel->sheet('Referanslar', function ($sheet) use ($testimonials) {
                $sheet->fromArray($testimonials, null, 'A1', true);
            });
        })->download('xlsx');
    }
}
