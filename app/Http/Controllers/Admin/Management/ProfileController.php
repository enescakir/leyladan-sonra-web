<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\ChildFilter;
use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(UserFilter $filters)
    {
        $users = auth()->user()->faculty->users()->filter($filters)->with('roles', 'media')->orderBy('first_name')->safePaginate();

        return view('admin.profile.index', compact('users'));
    }

    public function show(ChildFilter $filters)
    {
        $user = auth()->user();

        $children = auth()->user()->children()->filter($filters)->with('faculty')->safePaginate();

        return view('admin.profile.show', compact('children', 'user'));

    }

    public function edit()
    {
        $user = auth()->user();

        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string',
            'last_name'  => 'string',
            'email'      => 'email',
            'password'   => 'nullable|confirmed',
            'profile'    => 'nullable|image',
            'mobile'     => 'string',
        ]);
        $user = Auth::guard('web')->user();
        $user->fill($request->only([
            'first_name', 'last_name', 'email', 'password', 'birthday', 'gender', 'mobile', 'year'
        ]));

        if ($user->isDirty('email')) {
            $user->approved_at = null;
            $user->save();
            NotificationService::sendEmailActivationNotification($user);
        }
        $user->save();

        if ($request->hasFile('profile')) {
            $user->addMedia($request->profile, [], 'profile');
        }

        session_success('Profilin başarıyla güncelledi');

        return redirect()->back();

    }
}
