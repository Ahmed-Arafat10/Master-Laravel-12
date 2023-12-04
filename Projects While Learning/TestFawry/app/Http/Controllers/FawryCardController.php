<?php

namespace App\Http\Controllers;

use App\Http\Requests\FawryCardIssueTokenRequest;
use App\Http\Requests\FawryCardPayRequest;
use App\Models\Transaction;
use App\Models\UserCardToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FawryCardController extends FawryBaseController
{
    public function issueToken(FawryCardIssueTokenRequest $request)
    {
        $expire = explode('/', $request->expire);
       // dd($request->all(),$expire);
        $data = [
            'merchantCode' => $this->merchantCode,
            'customerProfileId' => Auth::id(),
            'customerMobile' => Auth::user()->phone,
            'customerEmail' => Auth::user()->email,
            'cardNumber' => $request->card_number,
            'cardAlias' => Str::upper(Auth::user()->name),
            'expiryYear' => $expire[1],
            'expiryMonth' => $expire[0],
            'cvv' => $request->cvv,
            'enable3ds' => false,
            'isDefault' => 0
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://www.atfawry.com/ECommerceWeb/api/cards/cardToken', $data);
        // https://atfawry.fawrystaging.com/fawrypay-api/api/cards/cardToken
        $apiResponse = $response->json();
        if ($apiResponse['statusCode'] != 200) return response()->json([
            'status' => false,
            'message' => $apiResponse['statusDescription'],
            'code' => $apiResponse['statusCode']
        ], 404);

        $userToken = UserCardToken::create([
            'user_id' => Auth::id(),
            'card_token' => $apiResponse['card']['token'],
            'first_six_digit' => $apiResponse['card']['firstSixDigits'],
            'last_four_digit' => $apiResponse['card']['lastFourDigits'],
            'brand' => $apiResponse['card']['brand'] ?? null,
            'is_Default' => 0,
        ]);
//        return response()->json([
//            'status' => true,
//            'data' => $userToken,
//            'code' => 201
//        ], 201);
       return $this->payWithCardToken([
           'card_token' => $apiResponse['card']['token'],
           'cvv' => $request->cvv,
           'amount' => "30.00"
       ]);
    }

    public function payWithCardToken($data = [])
    {
        $user = Auth::user();
        if (!UserCardToken::where('card_token', $data['card_token'])->exists())
            return $this->errorResponse('Card token is wrong', 404);
        $cardToken = $data['card_token'];
        $merchantCode = $this->merchantCode;
        $merchant_sec_key = $this->merchantSecKey;
        $cvv = $data['cvv'];
        $merchantRefNumber = uniqid('shit');
        $merchant_cust_prof_id = $user->id;
        $payment_method = 'CARD';
        $amount = $data['amount'];
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
        ])->post('https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge', $data);
        // https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge
        $apiResponse = $response->json();
        if ($apiResponse['statusCode'] != 200) return response()->json([
            'status' => false,
            'message' => $apiResponse['statusDescription'],
            'code' => $apiResponse['statusCode']
        ], 404);

        return redirect()->away($apiResponse['nextAction']['redirectUrl']);

    }

    public function callback()
    {
        $apiResponse = request()->all();
        if ($apiResponse['statusCode'] != 200) return response()->json([
            'status' => false,
            'message' => $apiResponse['statusDescription'],
            'code' => $apiResponse['statusCode']
        ], 400);
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
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
        return redirect()->route('transactions');
    }

    public function getCard()
    {
        $merchantCode = $this->merchantCode;
        $merchant_cust_prof_id = Auth::id();
        $merchant_sec_key = $this->merchantSecKey;
        $signature = hash('sha256', $merchantCode . $merchant_cust_prof_id . $merchant_sec_key);
        $baseURL = 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/cards/cardToken';
        $finalURL = $baseURL . '?merchantCode=' . $merchantCode . '&customerProfileId=' . $merchant_cust_prof_id . '&signature=' . $signature;
        $response = Http::get($finalURL);
        dd($response->json());
    }
}
