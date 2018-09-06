<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Filters\EmailSampleFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\EmailSample;

class EmailSampleController extends AdminController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(EmailSampleFilter $filters)
    {
        $samples = EmailSample::orderBy('category')->with('creator');

        $samples->filter($filters);

        $samples = $samples->paginate();

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
        return view('admin.emailsample.edit', compact('emailsample'));
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
        try {
            $emailsample->delete();
        } catch (\Exception $exception) {
            return api_error('E-posta örneği silinemedi');
        }
        return api_success($emailsample);
    }
}
