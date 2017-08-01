<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $diagnosises = Diagnosis::orderBy('name')->get();
    $diagnosises = $diagnosises->chunk(3);
    return view('admin.diagnosis.index', compact('diagnosises'));
  }

  public function create()
  {
    return view('admin.diagnosis.create');
  }

  public function store(Request $request)
  {
    $diagnosis = Diagnosis::create([
      'name' => $request->name
    ]);
    session_success(__('messages.diagnosis.create', ['name' =>  $diagnosis->name]));
    if ($request->ajax()) {
      return $diagnosis;
    }
    return redirect()->route('admin.diagnosis.index');
  }

  public function update(Request $request, Diagnosis $diagnosi)
  {
    $diagnosi->update($request->all());
    session_success(__('messages.diagnosis.update', ['name' =>  $diagnosi->name]));
    if ($request->ajax()) {
      return $diagnosi;
    }
    return redirect()->route('admin.diagnosis.index');
  }

  public function destroy(Diagnosis $diagnosi)
  {
    info($diagnosi);
    $diagnosi->delete();
    info($diagnosi);
    return $diagnosi;
  }
}
