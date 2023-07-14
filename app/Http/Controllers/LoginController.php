<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Captcha;
use DB, URL;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // use AuthenticatesUsers;

    public function __construct()
    {
        // $this->theme = Theme::uses('admin');
    }

    // protected $redirectTo = '/admin/dashboard';

    public function LoginredirectPage()
    {
        return redirect()->route('login');
    }

    public function doSignUp(Request $request)
    {
        $input = $request->all();
        $user_name = $request->input('username');
        // $validate_arr['name']           = 'required';
        $validate_arr['mobile_no']  = 'required|numeric|digits:10|min:6000000000';
        $validate_arr['username']      = 'required|unique:users,username|min:5|max:15|regex:/^[A-Za-z0-9_@._]*$/';
        // $validate_arr['captcha']        = 'required';
        $validate_arr['password']        = 'required|min:4|max:15|'; //regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$#%!]).*$/
        $validate_arr['password_confirm'] = 'required|same:password';
        $validate_messages['name.required']          = 'Please Enter Name';
        $validate_messages['mobile_no.required'] = 'Please Enter Mobile Number';
        $validate_messages['mobile_no.min']      = 'Please Enter Correct Mobile Number';
        $validate_messages['username.required']     = 'Please enter User Name';
        $validate_messages['username.min']     = 'User Name should be 5 characters to 15 characters long';
        $validate_messages['username.max']     = 'User Name should be 5 characters to 15 characters long';
        $validate_messages['username.regex']     = 'Username can include alpha numeric with underscore, dot and @ characters';
        $validate_messages['password.required']     = 'Please enter password';
        $validate_messages['password.regex'] = "Should have at least 1 lowercase & 1 uppercase & 1 number & special character. ";
        $validate_messages['password.min'] = ' Password should have minimum 8 characters ';
        // $validate_messages['captcha.required']       = 'Please enter Captcha';        

        $validatedData = $request->validate($validate_arr, $validate_messages);
        // $id =  $request->input('id');
        // id, fname, lname, username, password, mobile_no, touch_dt, touch_id, l_loggin
        $insert_application =  DB::table('users')->insert([
            'fname'         => $request->input('fname'),
            'lname'         => $request->input('lname'),
            'mobile_no'      => $request->input('mobile_no'),
            // 'email'         => $request->input('email'),
            'username'     => $request->input('username'),
            'touch_dt'    => date("Y-m-d H:i:s"),
            'password'      => bcrypt($request->input('password')),
        ]);
        $id = DB::getPdo()->lastInsertId();
        $message = "Sign Up sucessful!";

        $redirect_url = URL::to('/login');
        $json_data = array("status"  => true, "message"  => $message, 'id' => $id, "redirect_url" => $redirect_url,);
        return response()->json($json_data, 200);
    }

    public function loginPage()
    {
        return view('login');
    }

    public function signupPage()
    {
        $user = auth()->user();
        $data['user'] = $user;
        return view('signup', $data);
    }

    public function logout(Request $request)
    {
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function postLogin()
    {
        $cred = request()->validate([
            'username' => 'required',
            'password' => 'required', 'min:4', 'max:20',
            // 'captcha' => 'required|captcha'
        ]);

        // unset($cred['captcha']);
        // $cred['user_status'] = 1;
        if (Auth::guard('web')->attempt($cred, request()->filled('remember'))) {
            // Auth::logoutOtherDevices(request('password'));
            $user = auth('web')->user();
            $last_login = $user->l_loggin;
            Session::put('last_login', $last_login);
            DB::table('users')->where('id', $user->id)->update(['l_loggin' => date('Y-m-d H:i:s')]);

            $redirect = '/profile';
            $response = array('status' => true, 'redirect' => $redirect);
            echo json_encode($response);
        } else {
            $response = array('message' => 'User Name or Password is invalid', 'status' => false);
            echo json_encode($response);
        }
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function forgotPassword()
    {
        $this->theme->setTitle('eFisheries | Login');
        return $this->theme->layout('login')->of('admin::admin.forgotpassword')->render();

        //return view('admin::admin.forgotpassword');
    }

    public function resetPassword(Request $request)
    {
        $input = $request->all();
        $validation = request()->validate([
            'user_name' => 'required',
            'mobile_number' => 'required|digits:10',
            'captcha' => 'required|captcha'
        ]);

        unset($validation['captcha']);
        $validation['user_status'] = 1;

        $user_name = $input['user_name'];
        $mobile_number = $input['mobile_number'];

        $query = DB::table('users')->select('user_name', 'mobile_number')
            ->where('user_name', $user_name)
            ->where('mobile_number', $mobile_number)
            ->where('user_status', '=', 1)
            ->first();

        if ($query == '') {
            $response = array(
                'message' => 'Invalid User Name or Mobile Number'
            );
        } else {
            $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string_shuffled = str_shuffle($string);
            $password = substr($string_shuffled, 1, 7);
            $new_password = bcrypt($password);
            DB::table('users')->where('user_name', $user_name)->update([
                'password' => $new_password,
                'profile' => 0,
            ]);
            $message = "Your password has been reset. New password is: " . $password;
            $response_sms = Helper::sendSingleSMS($message, $mobile_number, "1007396979973627384");

            $redirect_url = URL::to('/login');
            $response = array('status' => true, 'redirect_url' => $redirect_url);
        }

        return $response;
    }
}
