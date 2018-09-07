<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use Excel;

class Diagnosis extends Model
{
    use BaseActions;
    // Properties
    protected $table = 'diagnoses';
    protected $fillable = ['name', 'category', 'desc'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                        ->orWhere('desc', 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function download($diagnosises)
    {
        $diagnosises = $diagnosises->get(['id', 'name', 'desc', 'created_at']);
        Excel::create('LS_Tanılar_' . date('d_m_Y'), function ($excel) use ($diagnosises) {
            $excel->sheet('Tanılar', function ($sheet) use ($diagnosises) {
                $sheet->fromArray($diagnosises, null, 'A1', true);
            });
        })->download('xlsx');
    }

    public static function toSelect($placeholder = null)
    {
        $result = static::orderBy('name')->pluck('name', 'name');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
