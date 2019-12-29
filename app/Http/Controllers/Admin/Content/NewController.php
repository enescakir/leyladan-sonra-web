<?php

namespace App\Http\Controllers\Admin\Content;

use App\Filters\NewFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Channel;

class NewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(NewFilter $filters)
    {
        $news = News::latest()->with('channel')->filter($filters)->safePaginate();

        $channels = Channel::toSelect('Hepsi');

        return view('admin.new.index', compact('news', 'channels'));
    }

    public function create()
    {
        $channels = Channel::toSelect();

        return view('admin.new.create', compact('channels'));
    }

    public function store(Request $request)
    {
        $this->validateNew($request);
        $new = News::create($request->only(['title', 'desc', 'link', 'channel_id']));

        session_success(__('messages.new.create', ['name' => $new->title]));

        return redirect()->route('admin.new.index');
    }

    public function edit(News $new)
    {
        $channels = Channel::toSelect();

        return view('admin.new.edit', compact('new', 'channels'));
    }

    public function update(Request $request, News $new)
    {
        $this->validateNew($request);
        $new->update($request->only(['title', 'desc', 'link', 'channel_id']));

        session_success(__('messages.new.update', ['name' => $new->title]));

        return redirect()->route('admin.new.index');
    }

    public function destroy(News $new)
    {
        $new->delete();

        return api_success($new);
    }

    private function validateNew(Request $request)
    {
        $this->validate($request, [
            'title'      => 'required|string|max:191',
            'desc'       => 'required|string',
            'link'       => 'required|string|max:191',
            'channel_id' => 'required|integer',
        ]);
    }
}
