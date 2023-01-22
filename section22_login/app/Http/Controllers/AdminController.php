<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
//    public function __construct()
//    {
//        return $this->middleware('role');
//    }

    public function index(Request $request)
    {
        $request->session()->put(['ahmed' => '123']);
        $request->session()->forget('ahmed');
        $request->session()->flush();
        return $request->session()->all();
        //return $request->session()->get('ahmed');
    }
}
