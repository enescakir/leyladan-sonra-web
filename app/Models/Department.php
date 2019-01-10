<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use Excel;

class Department extends Model
{
    use BaseActions;
    // Properties
    protected $table = 'departments';
    protected $fillable = ['name', 'desc', 'slug'];
    protected $slugKeys = ['name', 'id'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                   ->orWhere('desc', 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function download($departments)
    {
        $departments = $departments->get(['id', 'name', 'desc', 'created_at']);
        Excel::create('LS_Departmanlar_' . date('d_m_Y'), function ($excel) use ($departments) {
            $excel->sheet('Departmanlar', function ($sheet) use ($departments) {
                $sheet->fromArray($departments, null, 'A1', true);
            });
        })->download('xlsx');
    }

    public static function toSelect($placeholder = false)
    {
        $result = Department::orderBy('name')->pluck('name', 'name');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }
}
