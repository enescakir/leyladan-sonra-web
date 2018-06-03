<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectAfterLogout = '/admin/login';

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
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        if ($user->email_token != null) {
            session_info('E-posta adresinizi doğrulamamışsınız. <br> Tekrardan doğrulama kodu e-postanıza gönderildi.');
            $user->sendEmailActivationNotification();
            $this->guard()->logout();
            return back()->withInput($request->only('email', 'remember'));
        } elseif ($user->approved_at == null) {
            session_info('Hesabınızın fakülte yöneticiniz tarafından onaylanması gerekiyor.');
            $this->guard()->logout();
            return back()->withInput($request->only('email', 'remember'));
        } else {
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->intended(route('admin.dashboard'));
        }
    }
}
