<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.CreateNewUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        $request->validated();

        if (!$this->CheckPasswordMatch($request->password, $request->confpassword))
            return view('user.CreateNewUser')->with('message', 'Password is not matched');
        //dd($request->all());
        User::create(
            $request->except([
                '_token', 'confpassword'
            ])
        );
        return redirect(route('ViewAllPosts'))
            ->with('message', 'The User Has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }

    /**
     * @param string $pass
     * @param string $confpass
     * @return bool
     */
    public function CheckPasswordMatch(string $pass, string $confpass): bool
    {
        return $pass === $confpass;
    }
}
