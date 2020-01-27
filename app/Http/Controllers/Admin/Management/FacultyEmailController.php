<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
use App\Notifications\FacultyInform as FacultyInformNotification;
use Notification;

class FacultyEmailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Faculty $faculty)
    {
        $this->authorize('sendFaculty', [User::class, $faculty]);

        $roles = Role::toSelect();

        return view('admin.faculty.user.email', compact('faculty', 'roles'));
    }

    public function store(Request $request, Faculty $faculty)
    {
        $this->authorize('sendFaculty', [User::class, $faculty]);

        $roles = $request->roles;
        $sender = auth()->user();
        $subject = $request->subject;
        $body = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>',
            strip_tags($request->body, '<p><br><i><b><u><ul><li><ol><h1><h2><h3><h4><h5><a>'));

        $notifiables = NotificationService::sendFacultyInformNotification($faculty, $roles, $sender, $subject, $body);

        session_success($notifiables->count() . " kişiye başarılı bir şekilde e-posta gönderildi");

        return redirect()->back();
    }
}