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

    public function payment(Request $request){

        $planID = isset($request->pid)?base64_decode($request->pid):'';
        $data['apurl']= 'api/onApprove';
        $client_id = 'Aa6fAOYG0LtE4IXIJvu1PIn-Hh2Dx8f11mDutlc7IKwQBQ0DOzkYEotWvsRqaS8zaOhrcdCDFtnbdrc2';
        $data['src'] = 'https://www.paypal.com/sdk/js?client-id='.$client_id.'&components=buttons&vault=true&intent=subscription';
        $data['plan_id'] = $planID;
        $data['requestId'] = "12132131";
        return view('paypal', $data);
    }
    public function onApprove(Request $request){

        print_r($request->all());
        

    }
}
