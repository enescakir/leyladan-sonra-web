<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailSample;

class EmailSampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $samples = EmailSample::orderBy('category')->with('creator');

        if ($request->filled('search')) {
            $samples->search($request->search);
        }

        if ($request->filled('category')) {
            $samples->where('category', $request->category);
        }

        if ($request->filled('download')) {
            EmailSample::download($samples);
        }

        $samples = $samples->paginate($request->per_page ?: 25);

        $categories = EmailSample::toCategorySelect('Hepsi');
        return view('admin.emailsample.index', compact('samples', 'categories'));
    }

    public function create()
    {
        return view('admin.emailsample.create');
    }

    public function store(Request $request)
    {
        $sample = EmailSample::create([
            'name'     => $request->name,
            'category' => $request->category,
            'text'     => $request->text
        ]);

        session_success(__('messages.emailsample.create', ['name' =>  $sample->name]));
        return redirect()->route('admin.emailsample.index');
    }

    public function edit(EmailSample $emailsample)
    {
        return view('admin.emailsample.edit', compact(['emailsample']));
    }

    public function update(Request $request, EmailSample $emailsample)
    {
        $emailsample->update([
            'name'     => $request->name,
            'category' => $request->category,
            'text'     => $request->text
        ]);
        session_success(__('messages.emailsample.update', ['name' =>  $emailsample->name]));
        return redirect()->route('admin.emailsample.index');
    }

    public function destroy(EmailSample $emailsample)
    {
        $emailsample->delete();
        return api_success($emailsample);
    }
}
