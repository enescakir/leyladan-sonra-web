<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

use Excel;

class Sponsor extends Model
{
    use Base;
    // Properties
    protected $table    = 'sponsors';
    protected $fillable = ['name', 'link', 'order', 'logo'];
    protected static $cacheKeys = [
        'sponsors'
    ];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('link', 'like', '%' . $search . '%');
    }

    // Global Methods
    public static function download($sponsors)
    {
        $sponsors = $sponsors->get(['id', 'name', 'link', 'logo', 'created_at']);
        Excel::create('LS_Destekciler_' . date("d_m_Y"), function ($excel) use ($sponsors) {
            $sponsors = $sponsors->each(function ($item, $key) {
                $item->logo = asset(upload_path("sponsor", $item->logo));
            });
            $excel->sheet('Destekciler', function ($sheet) use ($sponsors) {
                $sheet->fromArray($sponsors, null, 'A1', true);
            });
        })->download('xlsx');
    }
}
