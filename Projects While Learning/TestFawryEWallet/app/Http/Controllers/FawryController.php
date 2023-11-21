<?php

namespace App\Http\Controllers;

use App\Http\Helper\Helper;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FawryController extends Controller
{
    public function create()
    {
        return view('fawry-pay');
    }

    public function storeR2f(Request $request)
    {
        return $this->fawryR2fPayment($request->phone);
    }

    public function storeQR()
    {
        return $this->fawryQrPayment();
    }

    private function getOrderAmount()
    {
        $res = 0;
        $products = Helper::getProducts();
        foreach ($products as $item) {
            $res += $item['qty'] * $item['price'];
        }
        return number_format($res, 2, '.', '');
    }

    private function getMerchantRefNumber()
    {
        return "FWRY_0" . Transaction::count() + 1;
    }

    private function getChargeItems()
    {
        $res = [];
        $products = Helper::getProducts();
        $i = 1;
        foreach ($products as $item) {
            $res[] = [
                'itemId' => $i++,
                'description' => $item['description'] ?? 'N/A',
                'price' => $item['price'],
                'quantity' => $item['qty'],
            ];
        }
        return $res;
    }

    private function fawryR2fPayment($phone)
    {
        $merchantCode = env('FAWRY_MERCHANT_CODE');
        $merchantRefNumber = $this->getMerchantRefNumber();
        $merchant_cust_prof_id = Auth::id();
        $payment_method = "MWALLET";
        $amount = $this->getOrderAmount();
        $debitMobileWalletNo = $phone;
        $merchant_sec_key = env('FAWRY_MERCHANT_SEC_KEY');

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
            'chargeItems' => $this->getChargeItems(),
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
            $this->storeTransaction($apiResponse,'R2F');
            return redirect()->route('transactions');
        } else return $apiResponse['statusDescription'];
    }

    private function storeTransaction($apiResponse,$type)
    {
        Transaction::create([
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
            'qr_code' => $apiResponse['walletQr'] ?? ''
        ]);
    }

    private function fawryQrPayment()
    {
        $merchantCode = env('FAWRY_MERCHANT_CODE');
        $merchantRefNumber = $this->getMerchantRefNumber();
        $merchant_cust_prof_id = Auth::id();
        $payment_method = "MWALLET";
        $amount = $this->getOrderAmount();
        $merchant_sec_key = env('FAWRY_MERCHANT_SEC_KEY');

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
            'chargeItems' => $this->getChargeItems(),
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
            $this->storeTransaction($apiResponse,'QR');
            return redirect()->route('transactions');
        } else return $apiResponse['statusDescription'];
    }

    public function viewTransactions()
    {
        return view('transactions', [
            'data' => Transaction::latest()->get()
        ]);
    }
}
