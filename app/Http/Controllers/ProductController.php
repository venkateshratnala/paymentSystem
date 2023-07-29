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

class ProductController extends Controller
{
    protected $isloggedIn = false;
    public function __construct()
    {

        if (auth('web')->check()) {
            $this->isloggedIn = true;
        }
    }

    public function products()
    {
        $user = auth('web')->user();
        $plans =  DB::table('plans as u');
        $data['plans'] = $plans->get();
        return view('product', $data);
    }
    public function initiate_subscription(Request $request)
    {
        $plan_id = $request->plan_id;
        $requestId = rand(10000000,99999999);
        if ($this->isloggedIn) {
            $redirect_url =  URL::to('payment?isReturn=true&pid=' . $plan_id.'&requestId='.$requestId);
            $response = array('status' => true, 'redirect_url' => $redirect_url,'isLogged_in'=> true);
            echo json_encode($response);
        } else {
            $redirect_url = URL::to('login?isReturn=true&pid=' . $plan_id.'&requestId='.$requestId);
            $response = array('status' => true, 'redirect_url' => $redirect_url,'isLogged_in'=> true);
            echo json_encode($response);
        }
    }

    private function generate_accessToken()
    {
        $client_id = 'Aa6fAOYG0LtE4IXIJvu1PIn-Hh2Dx8f11mDutlc7IKwQBQ0DOzkYEotWvsRqaS8zaOhrcdCDFtnbdrc2';
        $secret_id = 'EGIwtXMIBsxg4kthq-0_GY5Qt0_GjbpvCesTWH9j7PMcSRLplGNeBfKX_i-CRtkGkGc3p60I2O13RXgQ';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $secret_id);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

        $response = curl_exec($ch);

        curl_close($ch);
        $response1 =  json_decode($response, true);
        return $response1['access_token'];
    }

    public function fetch_product(Request $request)
    {
        $access_token = $this->generate_accessToken();
        $page_size =  10;
        $page = 1;
        $total_required = 'false';

        $url = 'https://api-m.sandbox.paypal.com/v1/catalogs/products?page_size=' . $page_size . '&page=' . $page . '&total_required=' . $total_required;
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        echo "<pre>";
        print_r(json_decode($response, true));
        echo "</pre>";
        exit;
    }

    public function create_product(Request $request)
    {
        $access_token = $this->generate_accessToken();

        $product  = new stdClass();
        $product->id = "99639040";
        $product->name = "Advertising service";
        $product->type = "SERVICE";
        $product->description = "Advertising service at very low cost";
        $product->category = "ADVERTISING";
        $product->image_url = "https://example.com/streaming.jpg";
        $product->home_url = "https://example.com/home";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/catalogs/products');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        $headers[] = 'Paypal-Request-Id: 12345';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        echo "<pre>";
        echo $result;
        echo "</pre>";
        exit;
    }
}
