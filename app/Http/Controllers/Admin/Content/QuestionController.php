<?php

namespace App\Http\Controllers\Admin\Content;

use App\Filters\QuestionFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(QuestionFilter $filters)
    {
        $questions = Question::orderBy('order')->filter($filters)->safePaginate();

        return view('admin.question.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.question.create');
    }

    public function store(Request $request)
    {
        $this->validateQuestion($request);
        $question = Question::create($request->only(['text', 'answer', 'order']));

        session_success(__('messages.question.create', ['name' => $question->text]));

        return redirect()->route('admin.question.index');
    }

    public function edit(Question $question)
    {
        return view('admin.question.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $this->validateQuestion($request);
        $question->update($request->only(['text', 'answer', 'order']));

        session_success(__('messages.question.update', ['name' => $question->text]));

        return redirect()->route('admin.question.index');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return api_success($question);
    }

    private function validateQuestion(Request $request)
    {
        $this->validate($request, [
            'text'   => 'required',
            'answer' => 'required',
            'order'  => 'numeric'
        ]);
    }
}
