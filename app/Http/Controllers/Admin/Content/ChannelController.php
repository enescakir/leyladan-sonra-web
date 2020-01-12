<?php

namespace App\Http\Controllers\Admin\Content;

use App\Filters\ChannelFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use Gate;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ChannelFilter $filters)
    {
        $this->authorize('website-content');

        $channels = Channel::filter($filters)->with('media')->withCount('news')->latest()->safePaginate();

        $categories = Channel::toCategorySelect('Hepsi');

        return view('admin.channel.index', compact('channels', 'categories'));
    }

    public function create()
    {
        return view('admin.channel.create');
    }

    public function store(Request $request)
    {
        $this->validateChannel($request);

        $channel = Channel::create($request->only(['name', 'channel', 'category']));
        $channel->addMedia($request->logo);

        session_success(__('messages.channel.create', ['name' => $channel->name]));

        return redirect()->route('admin.channel.index');
    }

    public function edit(Channel $channel)
    {
        return view('admin.channel.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $this->validateChannel($request, true);

        $channel->update($request->only(['name', 'channel', 'category']));

        if ($request->hasFile('logo')) {
            $channel->clearMediaCollection();
            $channel->addMedia($request->logo);
        }

        session_success(__('messages.channel.update', ['name' => $channel->name]));

        return redirect()->route('admin.channel.index');
    }

    public function destroy(Channel $channel)
    {
        $channel->news()->delete();
        $channel->delete();

        return api_success($channel);
    }

    private function validateChannel(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'logo'     => 'image' . ($isUpdate ? '' : '|required'),
        ]);
    }
}
