<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Used to process plans
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PhpParser\Node\Expr\FuncCall;
use stdClass;

class PaypalController extends Controller
{
    private $apiContext;
    private $mode;
    private $client_id;
    private $secret;

    // Create a new instance with our paypal credentials
    public function __construct()
    {
        // Detect if we are running in live mode or sandbox
        // if(config('paypal.settings.mode') == 'live'){
        //     $this->client_id = config('paypal.live_client_id');
        //     $this->secret = config('paypal.live_secret');
        // } else {
        $this->client_id = config('paypal.sandbox_client_id');
        $this->secret = config('paypal.sandbox_secret');
        // }

        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
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

    public function fetch_plan(){
        $access_token = $this->generate_accessToken();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/billing/plans?sort_by=create_time&sort_order=desc');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        
        $headers = array();
        $headers[] = 'Authorization: Bearer '.$access_token;
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Prefer: return=representation';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        echo "<pre>";
        print_r( json_decode($result,true));
        echo "</pre>";
        exit;
     

    }

    public function create_plan()
    {
        $access_token = $this->generate_accessToken();
        $i['product_id'] = "PROD-77R294826D120644K";
        $i["name"] = "Basic Plan";
        $i['billing_cycles'] = [];
        $trial = new stdClass();
        $trial->tenure_type = 'TRIAL';
        $trial->sequence = 1;
        $trial->frequency = new stdClass();
        $trial->frequency->interval_unit =  "DAY";
        $trial->frequency->interval_count = 14;
        $trial->total_cycles = 1;
        $trial->pricing_scheme = new stdClass();
        $trial->pricing_scheme->fixed_price = new stdClass();
        $trial->pricing_scheme->fixed_price->value = 1;
        $trial->pricing_scheme->fixed_price->currency_code =  "USD";

        $postTrial = new stdClass();
        $postTrial->tenure_type = 'REGULAR';
        $postTrial->sequence = 2;
        $postTrial->frequency = new stdClass();
        $postTrial->frequency->interval_unit =  "MONTH";
        $postTrial->frequency->interval_count = 1;
        $postTrial->total_cycles = 1;
        $postTrial->pricing_scheme = new stdClass();
        $postTrial->pricing_scheme->fixed_price = new stdClass();
        $postTrial->pricing_scheme->fixed_price->value = 10;
        $postTrial->pricing_scheme->fixed_price->currency_code =  "USD";
        $array = [];
        array_push($array, $trial);
        array_push($array, $postTrial);
        $i['billing_cycles'] = $array;
        $i['payment_preferences'] = [];

        $payment_preferences = new stdClass();
        $payment_preferences->auto_bill_outstanding = true;
        $payment_preferences->setup_fee = new stdClass();
        $payment_preferences->setup_fee->value = 10;
        $payment_preferences->setup_fee->currency_code = "USD";
        $payment_preferences->setup_fee_failure_action =  'CONTINUE';
        $payment_preferences->payment_failure_threshold = 1;
        $i['payment_preferences']  = $payment_preferences;

        $i['taxes'] = [];
        $taxes = new stdClass();
        $taxes->percentage = '10';
        $taxes->inclusive = false;
        $i['taxes'] = $taxes;
        $i['description'] = "Basic plan with 14 days trial";
        $i['status'] = "ACTIVE";
        $podtData = json_encode($i);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/billing/plans');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $podtData);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Paypal-Request-Id: 123456789';
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

    public function paypal_success(Request $request)
    {
        echo "<pre>";
        echo $request->all();
        echo "</pre>";
        exit;
    }
    public function paypal_cancel(Request $request)
    {
        echo "<pre>";
        echo $request->all();
        echo "</pre>";
        exit;
    }
}
