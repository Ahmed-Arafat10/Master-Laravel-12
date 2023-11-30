<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

class FawryController extends Controller
{
    use ApiResponser;

    protected string $callbackUrl = "http://127.0.0.1:8000/api/fawry/card/callback";
    protected string $merchantCode;
    protected string $merchantSecKey;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->merchantCode = env('FAWRY_MERCHANT_CODE');
        $this->merchantSecKey = env('FAWRY_MERCHANT_SEC_KEY');
    }
}
