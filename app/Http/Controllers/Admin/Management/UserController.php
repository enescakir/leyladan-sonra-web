<?php

namespace App\Http\Controllers\Admin\Management;

use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(UserFilter $filters)
    {
        $this->authorize('listAll', User::class);

        $users = User::filter($filters)->with(['roles', 'faculty'])->latest()->safePaginate();

        $roles = Role::toSelect('Yeni Görev', null);

        return view('admin.user.index', compact('users', 'roles'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $faculties = Faculty::toSelect('Fakülte seçiniz', 'full_name', 'id', 'name');
        $roles = Role::toSelect('Görev seçiniz', null);

        return view('admin.user.create', compact('faculties', 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $this->validateUser($request);

        $user = User::create($request->only([
            'first_name', 'last_name', 'email', 'password', 'faculty_id', 'birthday', 'gender', 'mobile', 'year'
        ]));
        $user->changeRole($request->role);
        session_success("<strong>{$user->full_name}</strong> başarıyla oluşturuldu. <br><strong>{$user->email}</strong> e-posta adresine doğrulama kodu gönderildi");
        $user->approve();
        NotificationService::sendEmailActivationNotification($user);

        return redirect()->to(request('redirect', route('admin.user.index')));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        dd($user);
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $faculties = Faculty::toSelect('Fakülte seçiniz', 'full_name', 'id', 'name');
        $roles = Role::toSelect('Görev seçiniz', null);

        return view('admin.user.edit', compact('user', 'faculties', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        if (!$request->ajax()) {
            $this->validateUser($request, $user->id);
        }

        $user->fill($request->only([
            'first_name', 'last_name', 'email', 'password', 'faculty_id', 'birthday', 'gender', 'mobile', 'year',
            'graduated_at', 'left_at'
        ]));
        if ($user->isDirty('email')) {
            $user->approved_at = null;
            $user->save();
            NotificationService::sendEmailActivationNotification($user);
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
        $this->authorize('update', $user);

        // TODO: delete user relations
        $user->delete();

        return api_success(['user' => $user]);
    }

    public function approve(Request $request, User $user)
    {
        $this->authorize('approve', $user);

        $user->approve($request->approval);

        if ($request->approval) {
            NotificationService::sendApprovedUserNotification($user);
        }

        return api_success([
            'approval' => (int)$user->isApproved(),
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