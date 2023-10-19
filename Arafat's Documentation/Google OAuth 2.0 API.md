````php
<?php

namespace App\Http\Controllers;

use App\Http\Facades\UserFacade;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $query = http_build_query([
            'scope' => 'https://www.googleapis.com/auth/userinfo.email',
            'access_type' => 'offline',
            'include_granted_scopes' => 'true',
            'response_type' => 'code',
            'state' => 'state_parameter_passthrough_value',
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'client_id' => env('GOOGLE_CLIENT_ID'),
        ]);
        $url = 'https://accounts.google.com/o/oauth2/v2/auth?' . $query;
        //dd('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
        return redirect($url);
    }

    public function handleGoogleCallback(Request $request)
    {
        $code = $request->input('code');
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = 'http://127.0.0.1:8000/api/auth/google/callback';

        // Exchange the code for an access token
        $client = new Client();
        $response = $client->post('https://accounts.google.com/o/oauth2/token', [
            'form_params' => [
                'code' => $code,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
            ],
        ]);

        $data = json_decode($response->getBody());

        $accessToken = $data->access_token;

        // Use the access token to make a request to the Google API to retrieve user information
        $response = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
            ],
        ]);

        $userData = json_decode($response->getBody());

        // Now you can store the user's Google ID in your database
        //dd($userData);
        return UserFacade::signUpOrIn($userData->email, $userData->name, $userData->id);
    }
}
````

````php
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
````

````php
<?php

namespace App\Http\Services;

use App\Models\User;
use App\Traits\ApiResponser;

class UserService
{
    use ApiResponser;

    public function signUpOrIn($email, $name, $googleID)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return $this->successResponse([
                'status' => 'success',
                'type' => 'SignIn',
                'token' => $user->createToken($email)->plainTextToken
            ], 200);
        } else {
            $name = explode(' ', $name);
            $user = User::create([
                'email' => $email,
                'first_name' => $name[0],
                'last_name' => $name[1],
                'phone' => 'NA',
                'avatar' => 'NA',
                'google_id' => $googleID,
            ]);
            return $this->successResponse([
                'status' => 'success',
                'type' => 'SignUp',
                'token' => $user->createToken($email)->plainTextToken
            ], 201);
        }
    }
}
````