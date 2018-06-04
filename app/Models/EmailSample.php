<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Base;
use Excel;

class EmailSample extends Model
{
    use Base;
    // Properties
    protected $table = 'email_samples';
    protected $fillable = [
        'name', 'category', 'text'
    ];

    // Helpers
    public static function download($samples)
    {
        $samples = $samples->get();
        Excel::create('LS_EpostaOrnekleri_' . date('d_m_Y'), function ($excel) use ($samples) {
            $excel->sheet('Epostalar', function ($sheet) use ($samples) {
                $sheet->fromArray($samples, null, 'A1', true);
            });
        })->download('xlsx');
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                        ->orWhere('text', 'like', '%' . $search . '%');
        });
    }

    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
