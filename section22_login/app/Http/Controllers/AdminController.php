<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('role');
    }

    public function index()
    {
        echo "I can access this method if I'm Admin";
    }
}
