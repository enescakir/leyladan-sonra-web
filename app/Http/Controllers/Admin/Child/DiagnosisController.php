<?php

namespace App\Http\Controllers\Admin\Child;

use App\Filters\DiagnosisFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(DiagnosisFilter $filters)
    {
        $diagnosises = Diagnosis::orderBy('name')->filter($filters)->safePaginate();

        return view('admin.diagnosis.index', compact('diagnosises'));
    }

    public function create()
    {
        return view('admin.diagnosis.create');
    }

    public function store(Request $request)
    {
        $diagnosis = Diagnosis::create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);
        session_success(__('messages.diagnosis.create', ['name' => $diagnosis->name]));
        return redirect()->route('admin.diagnosis.index');
    }

    public function edit(Diagnosis $diagnosi)
    {
        $diagnosis = $diagnosi;
        return view('admin.diagnosis.edit', compact(['diagnosis']));
    }

    public function update(Request $request, Diagnosis $diagnosi)
    {
        $diagnosi->update($request->all());
        session_success(__('messages.diagnosis.update', ['name' => $diagnosi->name]));
        return redirect()->route('admin.diagnosis.index');
    }

    public function destroy(Diagnosis $diagnosi)
    {
        $diagnosi->delete();
        return api_success($diagnosi);
    }
}
