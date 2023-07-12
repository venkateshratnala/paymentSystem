<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $user = DB::table('users')->select('fname')->get();
        echo $user;
        exit;
    }
}
