<?php

namespace App\Http\Controllers\Admin\Blood;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\User;

class BloodUserController extends AdminController
{
    public function edit()
    {
        $users = User::orderby('first_name')->get()->pluck('fullname', 'id');
        $responsibles = User::role('blood')->get()->pluck('id');

        return view('admin.blood.people', compact('users', 'responsibles'));
    }

    public function update(Request $request)
    {
        User::role('blood')->get()->each->removeRole('blood');
        User::whereIn('id', $request->users)->get()->each->assignRole('blood');

        session_success(__('messages.blood.people'));

        return redirect()->route('admin.blood.people.edit');
    }
}
