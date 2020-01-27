<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
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
        if (!$user) {
            session_error('Geçersiz e-posta aktivasyon linki kullanıldı.');
            return redirect()->route('admin.login');
        }

        $user->activateEmail();

        NotificationService::sendNewUserNotification($user);

        session_info('Fakülte yöneticiniz üyeliğinizi onayladıktan sonra giriş yapabilirsiniz.');

        return redirect()->route('admin.login');
    }
}
