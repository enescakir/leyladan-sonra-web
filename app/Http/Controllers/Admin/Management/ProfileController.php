<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\UserFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Child;
use App\Models\Process;
use App\Models\Faculty;
use Auth;

class ProfileController extends AdminController
{
    public function index(UserFilter $filters)
    {
        $users = User::latest()->with(['roles', 'faculty']);

        $users->filter($filters);

        $users = $this->paginate($users);

        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        $user->child_count = $user->children()->count();
        $user->visit_count = Process::where('created_by', $user->id)->where('desc', 'Ziyaret edildi.')->count();
        $user->child_delivered_count = $user->children()->where('gift_state', 'Teslim Edildi')->count();
        return view('admin.user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user->child_count = $user->children()->count();
        $user->visit_count = Process::where('created_by', $user->id)->where('desc', 'Ziyaret edildi.')->count();
        $user->child_delivered_count = $user->children()->where('gift_state', 'Teslim Edildi')->count();
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => 'string',
            'last_name'  => 'string',
            'email'      => 'email',
            'mobile'     => 'string',
        ]);

        $user->update($request->all());

        if ($request->filled('role')) {
            $user->syncRoles($request->role);
            if ($request->role == 'left') {
                $user->left();
            } elseif ($request->role == 'graduated') {
                $user->graduate();
            }
        }

        if ($request->hasFile('photo')) {
            ini_set('memory_limit', '-1');
            // $smallPhoto = Image::make($request->file('photo'))
            //     ->rotate(-$request->rotation)
            //     ->crop($request->w, $request->h, $request->x, $request->y)
            //     ->resize(100, 100)
            //     ->save('resources/admin/uploads/profile_photos/' . $user->id . '_s.jpg', 80);

            // $largePhoto = Image::make($request->file('photo'))
            //     ->rotate(-$request->rotation)
            //     ->crop($request->w, $request->h, $request->x, $request->y)
            //     ->resize(600, 600)
            //     ->save('resources/admin/uploads/profile_photos/' . $user->id . '_l.jpg', 80);

            ini_restore('memory_limit');

            $user->profile_photo = $user->id;
            $user->save();

            return redirect()->route('admin.user.edit', $id);
        }

        return $request->ajax()
            ? api_success(['role' => $user->role_display])
            : redirect()->route('admin.user.edit', $user->id);
    }

    public function destroy($id)
    {
        //
    }

    public function children($id)
    {
        $user = User::findOrFail($id);
        $user->child_count = $user->children()->count();
        $user->visit_count = Process::where('created_by', $user->id)->where('desc', 'Ziyaret edildi.')->count();
        $user->child_delivered_count = $user->children()->where('gift_state', 'Teslim Edildi')->count();
        $children = $user->children()->get();
        return view('admin.user.children', compact('children', 'user'));
    }

    public function childrenData($id)
    {
    }

    public function approve(Request $request, User $user)
    {
        $user->approve($request->approval);

        if ($request->approval) {
            $user->sendApprovedUserNotification();
        }

        return api_success([
            'approval' => (int) $user->isApproved(),
            'user'     => $user
        ]);
    }
}
