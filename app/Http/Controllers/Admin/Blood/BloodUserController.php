<?php

namespace App\Http\Controllers\Admin\Blood;

use App\Http\Controllers\Controller;
use App\Models\Blood;
use Illuminate\Http\Request;
use App\Models\User;

class BloodUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('auth', Blood::class);

        $users = User::toSelect(null, 'full_name', 'id', 'first_name');
        $responsibles = User::role('blood')->get()->pluck('id');

        return view('admin.blood.people', compact('users', 'responsibles'));
    }

    public function update(Request $request)
    {
        $this->authorize('auth', Blood::class);

        User::role('blood')->get()->each->removeRole('blood');
        User::whereIn('id', $request->users)->get()->each->assignRole('blood');

        session_success(__('messages.blood.people'));

        return redirect()->route('admin.blood.people.edit');
    }
}
