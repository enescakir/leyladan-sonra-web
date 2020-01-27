<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        if ($user->hasRole(UserRole::Left)) {
            session_info('Projeden ayrılan üyeler sisteme giriş yapamazlar. <br> Bir sorun olduğunu düşünüyorsanız fakülte sorumlunuzla görüşünüz.');
            $this->guard()->logout();
            return back()->withInput($request->only('email', 'remember'));
        } elseif ($user->email_token != null) {
            session_info('E-posta adresinizi doğrulamamışsınız. <br> Doğrulama kodu e-postanıza tekrardan gönderildi.');
            NotificationService::sendEmailActivationNotification($user);
            $this->guard()->logout();
            return back()->withInput($request->only('email', 'remember'));
        } elseif ($user->approved_at == null) {
            session_info('Hesabınızın fakülte yöneticiniz tarafından onaylanması gerekiyor.');
            $this->guard()->logout();
            return back()->withInput($request->only('email', 'remember'));
        } elseif ($user->faculty->isStopped()) {
            session_info("Fakülteniz {$user->faculty->stopped_at_label} tarihinde durdurulmuştur. Yönetim kuruluyla görüşmeniz gerekiyor.");
            $this->guard()->logout();
            return back()->withInput($request->only('email', 'remember'));
        } else {
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->intended(route('admin.dashboard'));
        }
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
}
