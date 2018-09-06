<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends AdminController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $questions = Question::orderBy('order');
        if ($request->filled('search')) {
            $questions = $questions->search($request->search);
        }
        if ($request->filled('download')) {
            Question::download($questions);
        }
        $questions = $questions->paginate($request->per_page ?: 25);
        return view('admin.question.index', compact(['questions']));
    }

    public function create()
    {
        return view('admin.question.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, Question::$rules);
        $question = Question::create($request->all());
        session_success(__('messages.question.create', ['name' =>  $question->text]));
        return redirect()->route('admin.question.index');
    }

    public function edit(Question $question)
    {
        return view('admin.question.edit', compact(['question']));
    }

    public function update(Request $request, Question $question)
    {
        $this->validate($request, Question::$rules);
        $question->update($request->all());
        session_success(__('messages.question.update', ['name' =>  $question->text]));
        return redirect()->route('admin.question.index');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return api_success($question);
    }
}
