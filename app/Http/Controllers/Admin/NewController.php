<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Channel;
use Excel;

class NewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $news = News::orderBy('id', 'DESC')->with('channel');
        if ($request->filled('search')) {
            $news->search($request->search);
        }

        if ($request->filled('download')) {
            News::download($news);
        }

        $news = $news->paginate($request->per_page ?: 25);
        return view('admin.new.index', compact(['news']));
    }

    public function create()
    {
        $channels = Channel::toSelect();
        return view('admin.new.create', compact(['channels']));
    }

    public function store(Request $request)
    {
        $this->validateNew($request);
        $new = News::create($request->all());
        session_success(__('messages.new.create', ['name' =>  $new->title]));
        return redirect()->route('admin.new.index');
    }

    public function edit(News $new)
    {
        $channels = Channel::toSelect();
        return view('admin.new.edit', compact(['new', 'channels']));
    }

    public function update(Request $request, News $new)
    {
        $this->validateNew($request);
        $new->update($request->all());
        session_success(__('messages.new.update', ['name' =>  $new->title]));
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
