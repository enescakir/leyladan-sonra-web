<?php

namespace App\Http\Controllers\Admin\Miscellaneous;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use PDF;

class FormController extends AdminController
{

    public function create()
    {
        return view('admin.form.create');
    }

    public function store(Request $request)
    {
        $text = $request->text;
        $random = str_random(6);

        return PDF::loadView('admin.form.show', compact('text','random'))
                  ->setPaper('a5', 'portrait')
                  ->setWarnings(false)
                  ->stream("Onam_Formu_{$random}.pdf");
    }
}