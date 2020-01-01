<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use PDF;

class FacultyFormController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('form', Faculty::class);

        return view('admin.faculty.form.create');
    }

    public function store(Request $request)
    {
        $this->authorize('form', Faculty::class);

        $text = $request->text;
        $random = str_random(6);

        return PDF::loadView('admin.faculty.form.show', compact('text', 'random'))
            ->setPaper('a5', 'portrait')
            ->setWarnings(false)
            ->stream("Onam_Formu_{$random}.pdf");
    }
}