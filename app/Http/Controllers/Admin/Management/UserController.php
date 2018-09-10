<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\UserFilter;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends AdminController
{
    public function index(UserFilter $filters)
    {
        $users = User::latest()->with(['roles', 'faculty']);
        $users->filter($filters);
        $users = $this->paginate($users);

        $roles = Role::toSelect('Yeni Görev', null);

        return view('admin.user.index', compact('users', 'roles'));
    }

    public function create()
    {
        $faculties = Faculty::toSelect('Fakülte seçiniz');
        $roles = Role::toSelect('Görev seçiniz', null);

        return view('admin.user.create', compact('faculties', 'roles'));
    }

    public function store(Request $request)
    {
        $this->validateUser($request);

        $user = User::create($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
            'faculty_id',
            'birthday',
            'mobile',
            'year'
        ]));
        $user->changeRole($request->role);
        session_success("<strong>{$user->full_name}</strong> başarıyla oluşturuldu. <br><strong>{$user->email}</strong> e-posta adresine doğrulama kodu gönderildi");
        $user->approve();
        $user->sendEmailActivationNotification();

        return redirect()->to(request('redirect', route('admin.user.index')));
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $faculties = Faculty::toSelect('Fakülte seçiniz');
        $roles = Role::toSelect('Görev seçiniz', null);

        return view('admin.user.edit', compact('user', 'faculties', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!$request->ajax()) {
            $this->validateUser($request, $user->id);
        }

        $user->fill($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
            'faculty_id',
            'birthday',
            'mobile',
            'year',
            'graduated_at',
            'left_at'
        ]));
        if ($user->isDirty('email')) {
            $user->approved_at = null;
            $user->sendEmailActivationNotification();
        }
        if ($user->isDirty('faculty_id')) {
            $user->children()->detach();
        }
        $user->save();
        if ($request->filled('left_at')) {
            $user->syncRoles('left');
        } elseif ($request->filled('graduated_at')) {
            $user->syncRoles('graduated');
        } else {
            $user->changeRole($request->role);
        }
        if ($request->ajax()) {
            return api_success(['user' => $user, 'role' => $user->role_display]);
        }

        session_success("<strong>{$user->full_name}</strong> başarıyla güncellendi.");

        return redirect()->to(request('redirect', route('admin.user.edit', $user->id)));

    }

    public function destroy(User $user)
    {
        $user->delete();

        return api_success(['user' => $user]);
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

    public function validateUser(Request $request, $userId = null)
    {
        return $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|max:255|email|unique:users' . ($userId
                    ? ',email,' . $userId
                    : ''),
            'password'   => 'min:6|confirmed' . ($userId
                    ? '|nullable'
                    : '|required'),
            'faculty_id' => 'nullable',
            'birthday'   => 'required|max:255',
            'mobile'     => 'required|max:255',
            'year'       => 'required|max:255',
            'role'       => 'required|max:255'
        ]);
    }
}