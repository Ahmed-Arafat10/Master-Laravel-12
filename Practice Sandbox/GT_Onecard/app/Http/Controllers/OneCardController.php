<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OneCardController extends Controller
{
    private $resellerUsername = null;
    private $secret = null;

    public function __construct()
    {
        $this->resellerUsername = env('ONECARD_USERNAME');
        $this->secret = env('ONECARD_SEC_KEY');
    }


    public function checkBalance(Request $request)
    {
        $data = [
            'resellerUsername' => $this->resellerUsername,
            'password' => md5($this->resellerUsername . $this->secret)
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://bbapi.ocstaging.net/integration/check-balance', $data);
        dd($response->json());
        /*
     array:8 [ // app\Http\Controllers\OneCardController.php:29
            "requestSrvTime" => "2023-12-06 21:28:01"
            "responseSrvTime" => "2023-12-06 21:28:01"
            "status" => true
            "errorCode" => null
            "errorMessage" => null
            "errorDesc" => null
            "balance" => 10000.0
            "currency" => "EGP"
    ]
 */
    }

    public function merchantList(Request $request)
    {
        $data = [
            'resellerUsername' => $this->resellerUsername,
            'password' => md5($this->resellerUsername . $this->secret)
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://bbapi.ocstaging.net/integration/get-merchant-list', $data);
        dd($response->json());
        /*
         array:7 [ // app\Http\Controllers\OneCardController.php:54
              "requestSrvTime" => "2023-12-06 21:31:22"
              "responseSrvTime" => "2023-12-06 21:31:22"
              "status" => true
              "errorCode" => null
              "errorMessage" => null
              "errorDesc" => null
              "merchantList" => []
        ]
         */
    }

    public function productsList(Request $request)
    {
        $merchantId = null;
        $data = [
            'resellerUsername' => $this->resellerUsername,
            'password' => md5($this->resellerUsername . $merchantId . $this->secret),
            'merchantId' => $merchantId,
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://bbapi.ocstaging.net/integration/detailed-products-list', $data);
        dd($response->json());
    }

    public function productDetailedInfo(Request $request)
    {
        $productID = "2862";
        $data = [
            'resellerUsername' => $this->resellerUsername,
            'password' => md5($this->resellerUsername . $productID . $this->secret),
            'productID' => $productID
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://bbapi.ocstaging.net/integration/detailed-products-list', $data);
        dd($response->json());
    }

    public function purchaseProduct(Request $request)
    {
        $productID = "2862";
        $resellerRefNumber = uniqid('test');
        $data = [
            'resellerUsername' => $this->resellerUsername,
            'password' => md5($this->resellerUsername . $productID . $resellerRefNumber . $this->secret),
            'productID' => $productID,
            'resellerRefNumber' => $resellerRefNumber
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://bbapi.ocstaging.net/integration/purchase-product', $data);
        dd($response->json());
    }

    public function transactionStatus()
    {
        $resellerRefNumber = '';
        $data = [
            'resellerUsername' => $this->resellerUsername,
            'password' => md5($this->resellerUsername . $resellerRefNumber . $this->secret),
            'resellerRefNumber' => $resellerRefNumber
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://bbapi.ocstaging.net/integration/check-transaction-status', $data);
        dd($response->json());
    }

}
