<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Sip_trx_user_log;

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
    protected $redirectTo = '/member';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function showLoginMemberForm()
    {
       return view('user.login');
    }

    public function showLoginAdminForm()
    {
       return view('admin.login');
    }

    public function loginMember(Request $request) {

        //validate the form data
        $validator = Validator::make($request->all(), [
            
            'email' => 'required|email',
            'password' => 'required|min:6'

        ]);
        
        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput($request->only('email','remember'));

        }

        if (Auth::guard('member')
            ->attempt(['email' => $request->email, 'password' => $request->password,'user_type' => 'user'], $request->remember)){
            
            // user log
            $inputLog = array(

                'sip_trx_user_logs_user_id' => Auth::guard('member')->user()->user_id,
                'sip_trx_user_logs_type' => 'login',
                'sip_trx_user_logs_desc' => 'Successfuly Login to system'

                );
            
            Sip_trx_user_log::create($inputLog);

            return redirect()
                    ->intended(route('dashboard_member'));

        }

        return redirect()
                    ->back()
                    ->with('message', 'Incorrect Email/Password')
                    ->withInput($request->only('email','remember'));
    }

    public function loginAdmin(Request $request) {

        //validate the form data
        $validator = Validator::make($request->all(), [
            
            'email' => 'required|email',
            'password' => 'required|min:6'

        ]);
        
        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput($request->only('email','remember'));

        }

        if (Auth::guard('admin')
            ->attempt(['email' => $request->email, 'password' => $request->password,'user_type' => 'admin'], $request->input('remember'))){

            return redirect()
                    ->intended(route('dashboard_admin'));

        }

        return redirect()
                    ->back()
                    ->with('message', 'Incorrect Email/Password')
                    ->withInput($request->only('email','remember'));
    }

    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();

        return redirect('/login/admin');
    }

    public function logoutMember()
    {
        Auth::guard('member')->logout();

        return redirect('/login/member');
    }

}
