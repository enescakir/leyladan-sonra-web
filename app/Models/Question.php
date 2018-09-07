<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use Excel;

class Question extends Model
{
    use BaseActions;

    // Properties
    protected $table = 'questions';
    protected $fillable = ['text', 'answer', 'order'];

    // Validation rules
    public static $rules = [
        'text'   => 'required',
        'answer' => 'required',
        'order'  => 'numeric'
    ];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('text', 'like', '%' . $search . '%')
                    ->orWhere('answer', 'like', '%' . $search . '%');
        });
    }

    public static function download($questions)
    {
        $questions = $questions->get();
        Excel::create('LS_Sorular_' . date('d_m_Y'), function ($excel) use ($questions) {
            $excel->sheet('Sorular', function ($sheet) use ($questions) {
                $sheet->fromArray($questions, null, 'A1', true);
            });
        })->download('xlsx');
    }
}
