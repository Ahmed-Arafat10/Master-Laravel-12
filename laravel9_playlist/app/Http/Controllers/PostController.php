<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function show($id)
    {
        return view('blog.index',[
            'myposts' => DB::table('posts')->get()
        ]);
    }
    public function index()
    {

    }
}
