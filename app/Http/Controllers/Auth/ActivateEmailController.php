<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewUser as NewUserNotification;

class ActivateEmailController extends Controller
{
    public function activate(Request $request, $token){
      // TODO: Send email after email is activated
      // Activate email
      $user = User::where('email_token', $token)->first();
      if($user){
        // $users = $user->faculty()->users()->title('Fakülte Sorumlusu')->get();
        // if(!$users)
        //   $users = User::title("Yönetici")->get();
        // foreach ($users as $u)
        //   $u->notify(new NewUserNotification($user));
        // session_info("Fakülte yöneticiniz üyeliğinizi onayladıktan sonra giriş yapabilirsiniz.");
      } else {
        session_error("Geçersiz e-posta aktivasyon linki kullanıldı.");
        return redirect()->route('admin.login');
      }
    }
}
