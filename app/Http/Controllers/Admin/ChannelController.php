<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Channel;
use Excel;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $channels = Channel::orderBy('id', 'DESC')->with('media')->withCount('news');

        if ($request->filled('search')) {
            $channels->search($request->search);
        }

        if ($request->filled('category')) {
            $channels->where('category', $request->category);
        }

        if ($request->filled('download')) {
            Channel::download($channels);
        }

        $channels = $channels->paginate($request->per_page ?: 25);
        $categories = Channel::toCategorySelect('Hepsi');
        return view('admin.channel.index', compact(['channels', 'categories']));
    }

    public function create()
    {
        return view('admin.channel.create');
    }

    public function store(Request $request)
    {
        $this->validateChannel($request);
        $channel = Channel::create([
          'name'     => $request->name,
          'category' => $request->category,
        ]);
        $channel->uploadMedia($request->logo);
        session_success(__('messages.channel.create', ['name' =>  $channel->name]));
        return redirect()->route('admin.channel.index');
    }

    public function edit(Channel $channel)
    {
        return view('admin.channel.edit', compact(['channel']));
    }

    public function update(Request $request, Channel $channel)
    {
        $this->validateChannel($request, true);
        $channel->update([
          'name'     => $request->name,
          'category' => $request->category,
        ]);
        if ($request->hasFile('logo')) {
            $channel->clearMediaCollection();
            $channel->uploadMedia($request->logo);
        }
        session_success(__('messages.channel.update', ['name' =>  $channel->name]));
        return redirect()->route('admin.channel.index');
    }

    public function destroy(Channel $channel)
    {
        $channel->clearMediaCollection();
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
