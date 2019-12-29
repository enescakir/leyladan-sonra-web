<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Filters\EmailSampleFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSample;

class EmailSampleController extends Controller
{

    public function index(EmailSampleFilter $filters)
    {
        $samples = EmailSample::orderBy('category')->with('creator')->filter($filters)->safePaginate();

        $categories = EmailSample::toCategorySelect('Hepsi');

        return view('admin.emailsample.index', compact('samples', 'categories'));
    }

    public function create()
    {
        return view('admin.emailsample.create');
    }

    public function store(Request $request)
    {
        $this->validateEmailSample($request);
        $sample = EmailSample::create($request->only(['name', 'category', 'text']));

        session_success(__('messages.emailsample.create', ['name' => $sample->name]));

        return redirect()->route('admin.emailsample.index');
    }

    public function edit(EmailSample $emailsample)
    {
        return view('admin.emailsample.edit', compact('emailsample'));
    }

    public function update(Request $request, EmailSample $emailsample)
    {
        $this->validateEmailSample($request);
        $emailsample->update($request->only(['name', 'category', 'text']));

        session_success(__('messages.emailsample.update', ['name' => $emailsample->name]));

        return redirect()->route('admin.emailsample.index');
    }

    public function destroy(EmailSample $emailsample)
    {
        $emailsample->delete();

        return api_success($emailsample);
    }

    private function validateEmailSample(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'category' => 'required|string',
            'text'     => 'required|string'
        ]);
    }

}