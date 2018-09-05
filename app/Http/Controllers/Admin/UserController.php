<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use App\Models\Child;
use App\Models\Process;
use App\Models\Faculty;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Faculty $faculty)
    {
        $users = User::orderBy('id', 'DESC')->with(['roles', 'faculty']);

        if ($request->filled('approval')) {
            $users->approved($request->approval);
        }
        if ($request->filled('role_name')) {
            $users->role($request->role_name);
            if ($request->role_name == 'left') {
                $users->withLefts();
            } elseif ($request->role_name == 'graduated') {
                $users->withGraduateds();
            }
        }
        if ($request->filled('faculty_id')) {
            $users->where('faculty_id', $request->faculty_id);
        }
        if ($request->filled('search')) {
            $users->search($request->search);
        }
        if ($request->filled('download')) {
            User::download($users);
        }
        $users = $users->paginate($request->per_page ?: 25);
        if ($request->has('page') && $request->page != 1 && $request->page > $users->lastPage()) {
            return redirect($request->fullUrlWithQuery(array_merge(request()->all(), ['page' => $users->lastPage()])));
        }
        return view('admin.user.index', compact(['users']));
    }

    public function faculty(Request $request, Faculty $faculty)
    {
        $users = $faculty->users()->orderBy('id', 'DESC')->with(['roles', 'faculty']);

        if ($request->filled('approval')) {
            $users->approved($request->approval);
        }
        if ($request->filled('role_name')) {
            $users->role($request->role_name);
            if ($request->role_name == 'left') {
                $users->withLefts();
            } elseif ($request->role_name == 'graduated') {
                $users->withGraduateds();
            }
        }
        if ($request->filled('search')) {
            $users->search($request->search);
        }
        if ($request->filled('download')) {
            User::download($users);
        }
        $users = $users->paginate($request->per_page ?: 25);
        if ($request->has('page') && $request->page != 1 && $request->page > $users->lastPage()) {
            return redirect($request->fullUrlWithQuery(array_merge(request()->all(), ['page' => $users->lastPage()])));
        }
        return view('admin.user.faculty', compact(['users', 'faculty']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
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
