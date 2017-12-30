<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewUser as NewUserNotification;

use App\Models\User;

class ActivateEmailController extends Controller
{
    public function activate(Request $request, $token)
    {
        $user = User::where('email_token', $token)->first();
        if ($user) {
            $users = $user->faculty->users()->title('Fakülte Sorumlusu')->get();

            // If it's a new faculty, there is no manager. So send notification to admins
            if (count($users) == 0) {
                $users = User::title("Yönetici")->get();
            }

            foreach ($users as $u) {
                $u->notify(new NewUserNotification($user));
            }

            $user->email_token = null;
            $user->save();
            session_info("Fakülte yöneticiniz üyeliğinizi onayladıktan sonra giriş yapabilirsiniz.");
        } else {
            session_error("Geçersiz e-posta aktivasyon linki kullanıldı.");
        }
        return redirect()->route('admin.login');
    }
}
