<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Excel;

trait Downloadable
{
    public static function download(Builder $builder, $dataMapper)
    {
        $elements = $builder->get();
        $classname = __('download.' . static::class);
        $filename = implode('_', ['LS', $classname, date('d_m_Y')]);
        if (is_callable($dataMapper)) {
            $elements = $elements->map($dataMapper);
        }
        Excel::create($filename, function ($excel) use ($elements, $classname) {
            $excel->sheet($classname, function ($sheet) use ($elements) {
                $sheet->fromArray($elements, null, 'A1', true);
            });
        })->download('xlsx');
    }
}
