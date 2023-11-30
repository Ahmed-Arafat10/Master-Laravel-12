<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCardToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FawryController extends Controller
{
    private string $callbackUrl = "http://127.0.0.1:8002/api/fawry/callback";
    private string $merchantCode;
    private string $merchantSecKey;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->merchantCode = env('FAWRY_MERCHANT_CODE');
        $this->merchantSecKey = env('FAWRY_MERCHANT_SEC_KEY');
    }

    public function issueToken(Request $request)
    {
        $data = [
            'merchantCode' => $this->merchantCode,
            'customerProfileId' => $request->customerProfileId,
            'customerMobile' => $request->customerMobile,
            'customerEmail' => $request->customerEmail,
            'cardNumber' => $request->cardNumber,
            'cardAlias' => $request->cardAlias,
            'expiryYear' => $request->expiryYear,
            'expiryMonth' => $request->expiryMonth,
            'cvv' => $request->cvv,
            'enable3ds' => false,
            'isDefault' => (bool)$request->isDefault
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://atfawry.fawrystaging.com/fawrypay-api/api/cards/cardToken', $data);
        $apiResponse = $response->json();
        if ($apiResponse['statusCode'] != 200) return response()->json([
            'status' => false,
            'message' => $apiResponse['statusDescription'],
            'code' => $apiResponse['statusCode']
        ], 404);

        $userToken = UserCardToken::create([
            'user_id' => $request->customerProfileId,
            'card_token' => $apiResponse['card']['token'],
            'first_six_digit' => $apiResponse['card']['firstSixDigits'],
            'last_four_digit' => $apiResponse['card']['lastFourDigits'],
            'brand' => $apiResponse['card']['brand'] ?? null,
            'is_Default' => (bool)$request->isDefault,
        ]);
        return response()->json([
            'status' => true,
            'data' => $userToken,
            'code' => 201
        ], 201);
    }

    public function payWithCardToken(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $cardToken = UserCardToken::findOrFail($request->card_token_id)->value('card_token');
        $merchantCode = $this->merchantCode;
        $merchant_sec_key = $this->merchantSecKey;
        $cvv = $request->cvv;
        $merchantRefNumber = uniqid('shit');
        $merchant_cust_prof_id = $user->id;
        $payment_method = 'CARD';
        $amount = $request->amount;
        $signature_body = $merchantCode .
            $merchantRefNumber .
            $merchant_cust_prof_id .
            $payment_method .
            $amount .
            $cardToken .
            $cvv .
            $this->callbackUrl .
            $merchant_sec_key;
        $hash_signature = hash('sha256', $signature_body);
        $data = [
            'merchantCode' => $merchantCode,
            'merchantRefNum' => $merchantRefNumber,

            'customerName' => $user->name,
            'customerMobile' => $user->phone,
            'customerEmail' => $user->email,
            'customerProfileId' => $merchant_cust_prof_id,

            'cardToken' => $cardToken,
            'cvv' => $cvv,
            'amount' => $amount,
            'currencyCode' => 'EGP',
            'language' => 'en-gb',

            'chargeItems' => [
                ['itemId' => '1',
                    'description' => 'yes',
                    'price' => $amount,
                    'quantity' => '1']
            ],
            'signature' => $hash_signature,
            'paymentMethod' => $payment_method, //  sus
            'description' => 'XYZ',
            'enable3DS' => true,
            'returnUrl' => $this->callbackUrl
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge', $data);

        $apiResponse = $response->json();
        if ($apiResponse['statusCode'] != 200) return response()->json([
            'status' => false,
            'message' => $apiResponse['statusDescription'],
            'code' => $apiResponse['statusCode']
        ], 404);
        return response()->json([
            'status' => true,
            'data' => [
                'redirectUrl' => $apiResponse['nextAction']['redirectUrl']
            ],
            'code' => 200
        ]);
    }

    /*
     array:16 [▼ // app\Http\Controllers\FawryController.php:137
          "type" => "ChargeResponse"
          "referenceNumber" => "770049033"
          "merchantRefNumber" => "shit656740586b3be"
          "orderAmount" => "100"
          "paymentAmount" => "100"
          "fawryFees" => "0"
          "orderStatus" => "PAID"
          "paymentMethod" => "CARD"
          "paymentTime" => "1701265500145"
          "customerName" => "arafat"
          "customerProfileId" => "5"
          "signature" => "11197ca20db4aa66524ef5b6d636c1bef2ef48259fe5760bb4465541aeb0f042"
          "taxes" => "0"
          "statusCode" => "200"
          "statusDescription" => "Operation done successfully"
          "basketPayment" => "false"
]
     */
    public function callback()
    {
        $apiResponse = \request()->all();
        if ($apiResponse['statusCode'] != 200) return response()->json([
            'status' => false,
            'message' => $apiResponse['statusDescription'],
            'code' => $apiResponse['statusCode']
        ], 400);
        $transaction = Transaction::create([
            'user_id' => 5,
            'ref_num' => $apiResponse['referenceNumber'],
            'merchant_ref_num' => $apiResponse['merchantRefNumber'],
            'order_amount' => $apiResponse['orderAmount'],
            'payment_amount' => $apiResponse['paymentAmount'],
            'fawry_fees' => $apiResponse['fawryFees'],
            'status' => $apiResponse['orderStatus'],
            'payment_method' => $apiResponse['paymentMethod'],
            'signature' => $apiResponse['signature'],
            'taxes' => $apiResponse['taxes'],
            'type' => 'CARD',
            'qr_code' => $apiResponse['walletQr'] ?? null
        ]);
        return response()->json([
            'status' => true,
            'data' => $transaction,
            'code' => 201
        ], 201);
    }

    public function getCard(Request $request)
    {
        $merchantCode = $this->merchantCode;
        $merchant_cust_prof_id = $request->user_id;
        $merchant_sec_key = $this->merchantSecKey;
        $signature = hash('sha256', $merchantCode . $merchant_cust_prof_id . $merchant_sec_key);
        $baseURL = 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/cards/cardToken';
        $finalURL = $baseURL . '?merchantCode=' . $merchantCode . '&customerProfileId=' . $merchant_cust_prof_id . '&signature=' . $signature;
        $response = Http::get($finalURL);
        dd($response->json());
    }
}
