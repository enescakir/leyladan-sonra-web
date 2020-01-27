<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $faculties = Faculty::toSelect(null, 'full_name', 'id', 'name');
        $roles = Role::toSelect();
        return view('admin.auth.register', compact('faculties', 'roles'));
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        session_info('E-posta adresinize doğrulama kodu gönderilmiştir.');
        NotificationService::sendEmailActivationNotification($user);

        return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|max:255|unique:users|email',
            'password'   => 'required|min:8|confirmed',
            'faculty_id' => 'required',
            'gender'     => 'required',
            'birthday'   => 'required|max:255',
            'mobile'     => 'required|max:255',
            'year'       => 'required|max:255',
            'role'       => 'required|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create($data);
        $user->assignRole($data['role']);
        return $user;
    }
}