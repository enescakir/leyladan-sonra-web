<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ActivateEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function activate(Request $request, $token)
    {
        $user = User::where('email_token', $token)->first();
        if ($user) {
            $users = $user->faculty->users()->role(UserRole::FacultyManager)->get();

            // If it's a new faculty, there is no manager. So send notification to admins
            if ($users->isEmpty()) {
                $users = User::role(UserRole::Admin)->get();
            }

            $users->each->sendNewUserNotification($user);

            $user->activateEmail();

            session_info('Fakülte yöneticiniz üyeliğinizi onayladıktan sonra giriş yapabilirsiniz.');
        } else {
            session_error('Geçersiz e-posta aktivasyon linki kullanıldı.');
        }
        return redirect()->route('admin.login');
    }
}
