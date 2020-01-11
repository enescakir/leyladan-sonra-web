<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Filters\VolunteerFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Volunteer;

class VolunteerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VolunteerFilter $filters)
    {
        $this->authorize('list', Volunteer::class);

        $volunteers = Volunteer::filter($filters)->withCount(['children', 'chats'])->latest()->safePaginate();

        return view('admin.volunteer.index', compact('volunteers'));
    }

    public function create()
    {
        $this->authorize('create', Volunteer::class);

        return view('admin.volunteer.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Volunteer::class);

        $this->validateVolunteer($request);

        $volunteer = Volunteer::create($request->only(['first_name', 'last_name', 'email', 'mobile', 'city']));

        session_success("<strong>{$volunteer->full_name}</strong> isimli gönüllü başarıyla oluşturuldu");

        return redirect()->route('admin.volunteer.index');
    }

    public function show(Volunteer $volunteer)
    {
        $this->authorize('view', $volunteer);

        $volunteer->load('chats.child', 'chats.faculty', 'chats.messages', 'children.faculty');

        return view('admin.volunteer.show', compact('volunteer'));
    }

    public function edit(Volunteer $volunteer)
    {
        $this->authorize('update', $volunteer);

        return view('admin.volunteer.edit', compact('volunteer'));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $this->authorize('update', $volunteer);

        $this->validateVolunteer($request, $volunteer->id);

        $volunteer->update($request->only(['first_name', 'last_name', 'email', 'mobile', 'city']));

        session_success("<strong>{$volunteer->full_name}</strong> isimli gönüllü başarıyla güncellendi");

        return redirect()->route('admin.volunteer.index');
    }

    public function destroy(Volunteer $volunteer)
    {
        $this->authorize('delete', $volunteer);

        $volunteer->chats()->delete();
        $volunteer->delete();

        return api_success(['volunteer' => $volunteer]);
    }

    public function validateVolunteer(Request $request, $volunteerId = null)
    {
        return $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|max:255|email|unique:volunteers' . ($volunteerId
                    ? ',email,' . $volunteerId
                    : ''),
        ]);
    }

}
