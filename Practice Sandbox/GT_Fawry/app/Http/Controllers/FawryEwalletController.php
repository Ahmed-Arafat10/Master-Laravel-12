<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FawryEwalletController extends FawryController
{
    public function storeR2f()
    {
        return $this->fawryR2fPayment(Auth::user()->phone);
    }

    public function storeQR()
    {
        return $this->fawryQrPayment();
    }

    private function getMerchantRefNumber()
    {
        return "FWRY_0" . Transaction::count() + 1;
    }

    private function fawryR2fPayment($phone)
    {
        $merchantCode = $this->merchantCode;
        $merchant_sec_key = $this->merchantSecKey;
        $merchantRefNumber = uniqid('shit');
        $merchant_cust_prof_id = Auth::id();
        $payment_method = "MWALLET";
        $amount = '500.00';
        $debitMobileWalletNo = $phone;

        $signature_body =
            $merchantCode .
            $merchantRefNumber .
            $merchant_cust_prof_id .
            $payment_method .
            $amount .
            $debitMobileWalletNo .
            $merchant_sec_key;
        $hash_signature = hash('sha256', $signature_body);
        $data = [
            'merchantCode' => $merchantCode,
            'merchantRefNum' => $merchantRefNumber,
            'customerProfileId' => $merchant_cust_prof_id,
            'customerName' => Auth::user()->name,
            'customerMobile' => $debitMobileWalletNo,
            'customerEmail' => Auth::user()->email,
            'amount' => $amount,
            'currencyCode' => 'EGP',
            'language' => 'en-gb',
            'chargeItems' => [
                [
                    'itemId' => '1',
                    'description' => 'N/A',
                    'price' => $amount,
                    'quantity' => '1',
                ]
            ],
            'signature' => $hash_signature,
            'debitMobileWalletNo' => $debitMobileWalletNo,
            'paymentMethod' => 'MWALLET',
            'description' => 'Example Description',
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://atfawry.fawrystaging.com/ECommerceWeb/api/payments/charge', $data);

        $apiResponse = $response->json();
        if ($apiResponse['statusCode'] == 200) {
           $res = $this->storeTransaction($apiResponse, 'R2F');
            return $this->showOne($res,201);
        } else $this->errorResponse($apiResponse['statusDescription'],404);
    }

    private function storeTransaction($apiResponse, $type)
    {
      $trans =  Transaction::create([
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
            'type' => $type,
            'qr_code' => $apiResponse['walletQr'] ?? null
        ]);
      return $trans;
    }

    private function fawryQrPayment()
    {
        $merchantCode = $this->merchantCode;
        $merchant_sec_key = $this->merchantSecKey;
        $merchantRefNumber = uniqid('shit');
        $merchant_cust_prof_id = Auth::id();
        $payment_method = "MWALLET";
        $amount = '500.00';

        $signature_body =
            $merchantCode .
            $merchantRefNumber .
            $merchant_cust_prof_id .
            $payment_method .
            $amount .
            $merchant_sec_key;
        $hash_signature = hash('sha256', $signature_body);
        $data = [
            'merchantCode' => $merchantCode,
            'merchantRefNum' => $merchantRefNumber,
            'customerProfileId' => $merchant_cust_prof_id,
            'customerName' => Auth::user()->name,
            'customerEmail' => Auth::user()->email,
            'amount' => $amount,
            'currencyCode' => 'EGP',
            'language' => 'en-gb',
            'chargeItems' => [
                [
                    'itemId' => '1',
                    'description' => 'N/A',
                    'price' => $amount,
                    'quantity' => '1',
                ]
            ],
            'signature' => $hash_signature,
            'paymentMethod' => 'MWALLET',
            'description' => 'Example Description',
        ];

        //dd(json_encode($data));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://atfawry.fawrystaging.com/ECommerceWeb/api/payments/charge', $data);

        $apiResponse = $response->json();
        //dd($apiResponse);
        if ($apiResponse['statusCode'] == 200) {
           $res =  $this->storeTransaction($apiResponse, 'QR');
            return $this->showOne($res,201);
        } return $this->errorResponse($apiResponse['statusDescription'],404);
    }

    public function viewTransactions()
    {
        return $this->showAll(Transaction::latest()->get(), 200);
    }
}
