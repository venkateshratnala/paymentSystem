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

class ProfileController extends Controller
{

    public function Profile()
    {
        $user = auth('web')->user();
        $data['userData'] = DB::table('users as u')
            ->where('u.id', $user->id)
            ->first();
        return view('profile', $data);
    }
}
