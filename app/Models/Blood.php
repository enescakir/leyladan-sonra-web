<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;
use App\Traits\HasMobile;
use Excel;

class Blood extends Model
{
    use BaseActions;
    use HasMobile;

    // Properties
    protected $table    = 'bloods';
    protected $fillable = ['rh', 'mobile', 'city', 'blood_type'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('id', $search)
                ->orWhere('mobile', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function download($bloods)
    {
        $bloods = $bloods->get(['id', 'blood_type', 'rh', 'mobile', 'city', 'created_at']);
        Excel::create('LS_KanBagisici_' . date("d_m_Y"), function ($excel) use ($bloods) {
            $excel->sheet('Bagiscilar', function ($sheet) use ($bloods) {
                $sheet->fromArray($bloods, null, 'A1', true);
            });
        })->download('xlsx');
    }
}
