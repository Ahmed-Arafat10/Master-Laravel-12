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
        //$request->session()->flash('message', 'post is created');
        $request->session()->reflash();
        return $request->session()->get('message');
        //return $request->session()->get('ahmed');
    }
}
