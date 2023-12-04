<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSignInRequest;
use App\Http\Requests\UserSignUpRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponser;

    public function signUp(UserSignUpRequest $request)
    {
        $user = User::create($request->all());
        $user->tokens()->delete();
        $user->Token = $user->createToken($user->email)->plainTextToken;
        return $this->showOne($user, 201);
    }

    public function signIn(UserSignInRequest $request)
    {
        if (Auth::attempt($request->all())) {
            Auth::user()->tokens()->delete();
            Auth::user()->Token = Auth::user()->createToken(Auth::user()->email)->plainTextToken;
            return $this->showOne(Auth::user());
        } else return $this->errorResponse('credentials are wrong', 401);
    }

    public function auth()
    {
        return $this->errorResponse('Not Authenticated', 403);
    }
}
