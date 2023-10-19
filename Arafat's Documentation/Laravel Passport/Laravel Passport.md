## Laravel Passport

> [https://oauth2.thephpleague.com/](https://oauth2.thephpleague.com/) read article to know difference between client credential/ password / authorization code grant / refresh token grant
> [https://oauth2.thephpleague.com/authorization-server/client-credentials-grant/](https://oauth2.thephpleague.com/authorization-server/client-credentials-grant/) credential grant
> [https://oauth2.thephpleague.com/authorization-server/resource-owner-password-credentials-grant/](https://oauth2.thephpleague.com/authorization-server/resource-owner-password-credentials-grant/) password grant
> [https://oauth2.thephpleague.com/authorization-server/auth-code-grant/](https://oauth2.thephpleague.com/authorization-server/auth-code-grant/) authorization code grant
> [https://oauth2.thephpleague.com/authorization-server/refresh-token-grant/](https://oauth2.thephpleague.com/authorization-server/refresh-token-grant/) refresh token

Install package
````php
composer require laravel/passport
````

- register passport service provider
````php
    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */
        \Laravel\Passport\PassportServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),
````

- migrate the database as passport will add its own tables
````php
php artisan migrate
````
````php
2016_06_01_000001_create_oauth_auth_codes_table ........................................................................................ 53ms DONE
2016_06_01_000002_create_oauth_access_tokens_table ..................................................................................... 40ms DONE
2016_06_01_000003_create_oauth_refresh_tokens_table .................................................................................... 49ms DONE
2016_06_01_000004_create_oauth_clients_table ........................................................................................... 23ms DONE
2016_06_01_000005_create_oauth_personal_access_clients_table ........................................................................... 10ms DONE
2019_08_19_000000_create_failed_jobs_table ............................................................................................. 23ms DONE
2019_12_14_000001_create_personal_access_tokens_table .................................................................................. 28ms DONE
````




-  This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens
````php
php artisan passport:install
````

    
- add the `Laravel\Passport\HasApiTokens` trait to your `App\Models\User model`. This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes. If your model is already using the `Laravel\Sanctum\HasApiTokens` trait, you may remove that trait
````php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
````

- you should define an api authentication guard and set the driver option to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests
````php
   'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
    ],
````

If you would like your client's secrets to be hashed when stored in your database, you should call the `Passport::hashClientSecrets()` method in the boot method of your `App\Providers\AuthServiceProvider` class:
````php
    public function boot(): void
    {
        Passport::hashClientSecrets();
    }
````


By default, Passport issues long-lived access tokens that expire after one year. If you would like to configure a longer / shorter token lifetime, you may use the `tokensExpireIn()`, `refreshTokensExpireIn()`, and `personalAccessTokensExpireIn()` methods. These methods should be called from the boot method of your application's `App\Providers\AuthServiceProvider` class
````php
/**
 * Register any authentication / authorization services.
 */
public function boot(): void
{
    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(30));
    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
}
````





## client credential grant
Before your application can issue tokens via the client credentials grant, you will need to create a client credentials grant client. You may do this using the `--client` option of the `passport:client` Artisan command
````php
php artisan passport:client --client
````
````php
 What should we name the client? [Laravel ClientCredentials Grant Client]:
 > ahmed arafat

New client created successfully.
Here is your new client secret. This is the only time it will be shown so don't lose it!

Client ID: 3
Client secret: V5So7ExOVpbJVhiu85UDWZJ9dlLUz0c7uLSy2Bap
````

to use this grant type, you may add the `CheckClientCredentials` middleware to the `$middlewareAliases` property of your application's `app/Http/Kernel.php` file
````php
protected $middlewareAliases = [
    'client.credential' => Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
];
````


- Now in Postman add new `POST` request to `http://127.0.0.1:8000/oauth/token`
- In request body > `form-data` add these values
````php
grant_type:client_credentials
client_id:3
client_secret:V5So7ExOVpbJVhiu85UDWZJ9dlLUz0c7uLSy2Bap
scope:"OPTIONAL"
````
````php
{
    "token_type": "Bearer",
    "expires_in": 31622400,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiYjI2MjZkZjg0YjM1NDE3MDIxNTVlYWYzYjc2YWFlZWRjMWIwYjk4MzU4ZjZkOWExZDhkODk4YzU1MjBmZWE5NDFmN2YxOTczYzExMmUxNDEiLCJpYXQiOjE2OTc2MzAwMjUuMjUxODgsIm5iZiI6MTY5NzYzMDAyNS4yNTE4ODIsImV4cCI6MTcyOTI1MjQyNS4yNDMyNjEsInN1YiI6IiIsInNjb3BlcyI6W119.gkWdxAb6kRtj9EKT0zn2VPnBFfqbIHUF0LjCr1pGrEnWGphyFOV76kGN7z0XcVb1XMZu_NOkA1Hweq-QDAA7MVHbmKpuGPMoR6KGLenf7eBqMXVlW-YvK9suwL6_EDO32i48xMAMiowedw9Rh-264w72Vong1p0gprLyyReNLEsrxnthkKKbjwpojncm-x2wDyZS451yMTRAJueRlNDUqKMQGIrH8Yn-wmST0TnTq3XJwF576AtBELLGGVyF7HtkcKsf-U0U8PfNE5Fzu91YEl65BcvlCqK6IKv8QvoQNvpnLSuj1CJI0-MpqIYTctIoV1bECZ1Z5yVlWnIM_GSkvK1E3GpMWnlYJYZBQ-QGffC0bihswOxSndlMMKdAWiRNrRTlDyMVMTXud8wMIJ4oaID4Rz6C3Vo78gz2veBanogAAtvo4q2MqMFB7u_sGFYkPKC0MFNh9euudTnUgxzc-VUwb9C8DWo8xqmieLWUqt7olf8ypyz9YniUaFtf3CCZZcU4YxBPx1O5GdhOUtfg7lAEoBLlhvb5iYFRu64XBF2u5t6wxbjXCT16Gs4Nf-FgKmHFlU6AU6trz5aMdm23qaAZaHlFgTwoorRRmx7d5nULLDNpeyjt-0bTZPKp1E-P3wtTHoQMsjVXPl0kbzxIhKEFQALp1kqBeB9U-SmWTsg"
}
````

````php
Route::get('/users', function (Request $request) {
    ...
})->middleware('client.credential');
````
> don't forget to add in header `Authorization : Bearer access_token`



## Password Grant
The OAuth2 password grant allows your other first-party clients, such as a mobile application, to obtain an access token using an email address / username and password. This allows you to issue access tokens securely to your first-party clients without requiring your users to go through the entire OAuth2 authorization code redirect flow.

Before your application can issue tokens via the password grant, you will need to create a password grant client. You may do this using the `passport:client` Artisan command with the `--password` option. If you have already run the `passport:install` command, you do not need to run this command:
````php
php artisan passport:client --password
````


#### Requesting Tokens
- using laravel not postman this time
````php
use Illuminate\Support\Facades\Http;
 
$response = Http::asForm()->post('http://127.0.0.1:8000/oauth/token', [
    'grant_type' => 'password',
    'client_id' => '4',
    'client_secret' => 'vDYb4eyIp4Vm2a6H5zG9GJ0dvLcnFP2FUAU7492u',
    'username' => 'ahmed@gmail.com',
    'password' => 'password',
    'scope' => '*', // optional
]);
 
return $response->json();
````

````php
{
    "token_type": "Bearer",
    "expires_in": 18000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiN2Q1OTY3Nzc2YTg1YzA1YmYwNGNlZTQ3MzlkMWE4YzE5YmI3MjE0ODFhY2Y2ZGRiM2VhMWJmMzYzZDhmZDQ0YjFjZTNiMTgyMzE5NzYzZTciLCJpYXQiOjE2OTc2MzQzOTcuOTQwOTU4LCJuYmYiOjE2OTc2MzQzOTcuOTQwOTYsImV4cCI6MTY5NzY1MjM5Ny45Mjg5LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.pfQRHDhrk66YjvM4_-7uQgldlaLJZ_F1VUi2Ucgz3RqFGLHf2wdPkzezRERKBW6mimCt0c6BuC4REUy7Oo02ZOHjLixWYdfCl9kKBVNVIdCRMmP91pJ-HEFXp5Sf-6DK2TGTqBRJWAVFvaCf4kUvpGlwhrseSDco8ni2BkW49A6ezqOri5c3f-5prQRwnUuncRt2y-2sDoZ33hqY-R-Usu4WMSaDBUNdnyW1fQn7a28H13AuHQkXjq7L11oKpVv-uNJgj46ZK1CupAxDszEwr4URHx7tTt09Tv-JSl7h8dME6f0pAqw8wblABK2CTvuhRX1KHu7nMb7OW7tMI8ZsFc4WFU_F0sRGdkDDyHHp1sppfD3gcMHMSWt9EGRCxX2-Z4MtmGMLX5lGEDOX5P6ggCwoldRsKD73124yI7nxeAWn6jtPyg8FIzadnSEOP-24jjvDElm0cjcEG9QkzKzm4hyvMJA3e9ZJERNqt8wBsQzjCoO6AmUykRXO25fNc-z1sElCvWTyTqU3BsHgrY0nNtaXTeXjSO4-UCrnvol1hI_orENyh9Ga2uVNsuS6FzDaIpnlEyuT-VOxi8zcUoxas9brL7XHsJyIHYC7UGXOF4WOZ5_S1U35ofNqCNRx9TM48dYNcDanmD-vmWkUpMKBAV1_tAPgNGxHHMuh9bdDy_A",
    "refresh_token": "def50200027dc859170a2575b32f07aa3bb596dc4d66cef1fbca97870a2117933f9a8f8bc4ca51d1519810d6748a9e353c0210639b0901a456a042914886fd4227f0ce58ea1f1385f407efc4abbd2628a5b525b7aa1fe5fafc167dcc5db7cda447efbd6d10fec16d1a4e4a2eef212ce09b042b102ec785eab85bfd93c75528a3e1f25eb70636747809ae70c44366dde3e9d09dde4bc8d26d59651197a621078ecfc68ce2b581bb45a24ae2d88a66b14e1bb7d515cc62d7753c629e19a1a7e0e71b9a2c7a3f42e6fd4f90f5b14f58608c0d0a28447cc6ab5062c56b7d5212a09bf6f86c4236147b82a8843e133f6db603cd5eae0db671693719061b498d4cddf50b69ea7f095e6ca90c1461ac3f63291af4d8fa0bc2a514fb32f000a21d33793b5f4aac3d2a8872df2120cfa2444ab627914ae65baefc34fa56f965469a597ee92176358a1de49421cf8475479d3f2740220e6f69047b8a5236b15f0c947b65b0c42955a8"
}
````
> then add this `access_token` in Authorization header



- protecting routes or controllers
````php
Route::get('test2',function (){
    return "Authorized";
})->middleware(['auth:api']);
````
> `middleware(['auth:api'])` to add  password grant




#### Passing The Access Token
When calling routes that are protected by Passport, your application's API consumers should specify their access token as a Bearer token in the Authorization header of their request. For example, when using the Guzzle HTTP library:
````php
use Illuminate\Support\Facades\Http;
 
$response = Http::withHeaders([
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,
])->get('https://passport-app.test/api/user');
 
return $response->json();
````


## Authorization Code Grant
#### Redirecting For Authorization
Once a client has been created, developers may use their client ID and secret to request an authorization code and access token from your application. First, the consuming application should make a redirect request to your application's `/oauth/authorize` route like so:
````php
    Route::get('/redirect', function (Request $request) {
        $request->session()->put('state', $state = \Illuminate\Support\Str::random(40));

        $query = http_build_query([
            'client_id' => '6',
            'redirect_uri' => 'http://127.0.0.1:8000/api/auth/callback',
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect('http://127.0.0.1:8000/oauth/authorize?' . $query);
    });
````
#### Converting Authorization Codes To Access Tokens
If the user approves the authorization request, they will be redirected back to the consuming application. The consumer should first verify the state parameter against the value that was stored prior to the redirect. If the state parameter matches then the consumer should issue a POST request to your application to request an access token. The request should include the authorization code that was issued by your application when the user approved the authorization request:
````php
    Route::get('auth/callback', function (Request $request) {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class,
            'Invalid state value.'
        );
   
        $response = \Illuminate\Support\Facades\Http::asForm()
            ->post('http://127.0.0.1:8000/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => 6,
            'client_secret' => 'cmrowEm8f2ma4Kj3owxSm7QaLgUifNys6TFuB8E4',
            'redirect_uri' => 'http://127.0.0.1:8000/api/auth/callback',
            'code' => $request->code,
        ]);

        return $response->json();
    });
````
> now issued access token
````php
{
    "token_type": "Bearer",
    "expires_in": 18000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI2IiwianRpIjoiNzhmMDI3MjkxYzFlNmNiYjEwM2QzMzFjYWM3ZGJmYWZkZDMwNGU3M2E5NWQwMTMyMGJiYmFlOWU0MTcyZDk5MjZhMzViNWFiZWFlYTI2YWQiLCJpYXQiOjE2OTc2OTk3MjUuMTIwMTkzLCJuYmYiOjE2OTc2OTk3MjUuMTIwMTk1LCJleHAiOjE2OTc3MTc3MjUuMTA1MTI5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.VqKjFynP6vJ_Emcvg6ta7eof_HFF6IvOI3GPyJE0urtcITMt5OiIFIUHiweqEsOlfkGo4BJDSEKsSM1orE5UlYsVzjMdyitpqBKKmr8WuJ7ORkWUi2eOhEC2egc599jyJUK_3aTnDw92wbZVSSthI8FQt5C--5JfEmF1xGWUjlgsRE5MLRvzlX0UTmrY_caeKBnqxvKiATwEGxVWbVk4zW3-IV04w51hW1wd1q3t26DTP_497ZRud7F7sjo7b4JqOOJ-rN1BuyQauxtYKQmJ8abs0k5VgMGDlVuf7h2i2iHUrzKDTrRghWyD_a8elIqUvyvCqp5h8uXlNB4yVRJLo5osA2ZZntIi2x5eJxyTg_1RPyqZqqJnrfAdhrgwrqgxhekZ5t0zA1_ilGze6iYOWgO2L5P2cQ0VmViBzc4Yh2reAMteuzd-NDNmMgJk0QZzeHbNZ4h5KI5ArUfCDS5XZ8fIfIhi2Kfq1lX3x91Hrszs4If4AOF6pXZSYh28CXlG0iZXma9_qOeDxHUDXUDaQjowxYxBQijmqfoZIbbFu_fZYupf-wSPqwuHPYWsk3lUnFxQhshCyZVqkuAYMwdXCNTlmNJMhLOkpPRSB1OibYYuKDjoomh6MTl1_Bbf3PZiLN6qI6Avhe2_e1V2uthYtKAvEaP8ctUhnVhDEnGJzQQ",
    "refresh_token": "def50200897d3057d82e7b35cc60e4cb3ddc049052ac167aac7022c3c0763343d71f0f81a7aa73473a13ccbe4a19187589a304dd0a03797ed2577f7f47f77002301bfee85eb93a6f22c16ab0941ba7d741e71481c6a6f3634f8cfb574890692a9d9cc1ed6281c0aa606bc560381144d3aacb6976d586154efeeb18d85cf3d4c2e47f9bf280a8623e780afb4069fb3f4293703437282109691936c1cdcf4fc827f9effbdd3a0fd97bb95e39f2ce741f8f3b2f629e71c963ac86c8e51cf9c2602d5beb1632be9806f70f1c3fc00849d665db1a8085edb4b7a4742f269142138a91f7be12cb738fd7ec35a83b4ac66ef519820a126c7b2480ec6b2c58a6a6cab7cafa6737f8f0bd0c843f18a5c7cd5cfdf2bf8c1f10515aaa7db81de949add67cb4c7850468df195d9c1879796f795c4191c0229c11f7447b9aad5c72be48d0af37eeff1180264bb8cda0d34e954ee2d6532986796b74fe0abca5ecd36408fbb0a5e5"
}
````
> you can do so in Postman (It works with me in postman not using `Http`)


### Refreshing Tokens
If your application issues short-lived access tokens, users will need to refresh their access tokens via the refresh token that was provided to them when the access token was issued:
````php
use Illuminate\Support\Facades\Http;
 
$response = Http::asForm()->post('http://127.0.0.1:8000/oauth/token', [
    'grant_type' => 'refresh_token',
    'refresh_token' => 'def50200897d3057d82e7b35cc60e4cb3ddc049052ac167aac7022c3c0763343d71f0f81a7aa73473a13ccbe4a19187589a304dd0a03797ed2577f7f47f77002301bfee85eb93a6f22c16ab0941ba7d741e71481c6a6f3634f8cfb574890692a9d9cc1ed6281c0aa606bc560381144d3aacb6976d586154efeeb18d85cf3d4c2e47f9bf280a8623e780afb4069fb3f4293703437282109691936c1cdcf4fc827f9effbdd3a0fd97bb95e39f2ce741f8f3b2f629e71c963ac86c8e51cf9c2602d5beb1632be9806f70f1c3fc00849d665db1a8085edb4b7a4742f269142138a91f7be12cb738fd7ec35a83b4ac66ef519820a126c7b2480ec6b2c58a6a6cab7cafa6737f8f0bd0c843f18a5c7cd5cfdf2bf8c1f10515aaa7db81de949add67cb4c7850468df195d9c1879796f795c4191c0229c11f7447b9aad5c72be48d0af37eeff1180264bb8cda0d34e954ee2d6532986796b74fe0abca5ecd36408fbb0a5e5',
    'client_id' => '6',
    'client_secret' => 'cmrowEm8f2ma4Kj3owxSm7QaLgUifNys6TFuB8E4',
    'scope' => '',
]);
 
return $response->json();
````
> new issued token
````php
{
    "token_type": "Bearer",
    "expires_in": 18000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI2IiwianRpIjoiOWNiNmMxYzZkNjM0YTY1ODM2YTk1ZTYyMjRhY2ZiZDMwYjJkZDM4YzE4MjcxY2YxYWRhMWE3NWM4NWNiMjE1MGQ1ZTgyNTk0NzIwZDk1MzQiLCJpYXQiOjE2OTc3MDA0NDQuMDAwODU0LCJuYmYiOjE2OTc3MDA0NDQuMDAwODU2LCJleHAiOjE2OTc3MTg0NDMuOTkzNDQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.Xc9ob-N5iSS5PMrklcNfTYyiXh0jvFoYtHPy26HEkYPnfKTt4o7OEqwSel7jzPFhM4vf2AjwpFyrpiFvnJm3f5CSYgxun4q4WpeNuy50tP1LkWf3RSY9bzluokF5n6YUR-Rh2WxMAzyutSsVLR4rUI3_iPzZ8uu2bN4NrIVlhJzsiy_JLJxHq4ZqVZCtUBW3vnjiH9-EMOxc3rP20lE9F8J6Im6wJo_-fTTLRLfA7ultS97GDkSL6clS7gGJ-jUdzHZh_mxHCmBBBJsIo8WAC654DJMf9BaSEnlzPGpIK7ch0u816JZgR8md8vHo0XMamGthYg3Lu6i53QMk5DXp86W0GlE8AmDe8Qdum1g8UqKOjh8Ny_vpS9SC8IQ6mA_RW9yAObcfyQ4K7c_kOZwAYpLCI7WKVVT6YRxS5GRblaf4JazY26xTSow05DOEGnyiLO4Ras85tGGXzNDiFB3zpmj5utaXQ5uils6RI11aCo11TjogLkd-Sfbfw_QqjgT2eYf2XHfZ2MYwFxLgq2_tYDCCaaKv788Xj-GJxB3aSuZk-s4tghP5G6Gn8FhodpZFVW1Ab6lw744ojWV5loXcQimxW3rI0inKI1MjQMjg0EoM6khu9tSW4YDKFcuTbJfTG-DAvMj4xoJ9dEk7wltyu3kS9vblG44zErmFz2ctLTY",
    "refresh_token": "def50200cc8c91c4ee29a51c5df0170020ec701eabad7d3ec4de4bd7e9aaa5936fe21e12f7db7fd49e7b38bc7851f8db5773eb4dd2c81054c07a737b1e1a75b1f0c357050593cde7ce614a1442e9d62fcc2d0e88bd8e6863e72220610b401f541b44acc7bea32e2be5cb6de351747534a458f29dd25a362bf7780c10007228ebd98c30535f50f92b0d7369956a595136c1a50b0d2b4bc68ad5e826b1685376b3abe118bd74203abf583cd0501e00b7fe552d4c548f421ecf31700357ebb968529846b052df61233acef1a23ffb28de64bc85ad79cdead31a85c9167ec875817d30b713d5c783751bd303c41a81ab882747ecf401acd21cbe5cbe8e1bf5bd4d0d1e919331eb0bbf9424f5a3790d7a9c2031a328b6661a6eeb074373baf372c5c562a9b8a77a790d113a22e7d8386f06fc5c9baed6724acbc2e8a158316620569fb7faff0a530f38ad0cb658cd6c1ce6539590b9f34c0bd0e0493f8ff53534c27a45"
}
````


### Personal Access Tokens
Sometimes, your users may want to issue access tokens to themselves without going through the typical authorization code redirect flow. Allowing users to issue tokens to themselves via your application's UI can be useful for allowing users to experiment with your API or may serve as a simpler approach to issuing access tokens in general.

#### Creating A Personal Access Client
Before your application can issue personal access tokens, you will need to create a personal access client. You may do this by executing the passport:client Artisan command with the `--personal` option. If you have already run the `passport:install` command, you do not need to run this command:
````php
php artisan passport:client --personal
````

After creating your personal access client, place the client's ID and plain-text secret value in your application's `.env` file:
````php
PASSPORT_PERSONAL_ACCESS_CLIENT_ID="client-id-value"
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET="unhashed-client-secret-value"
````

#### Managing Personal Access Tokens
Once you have created a personal access client, you may issue tokens for a given user using the `createToken()` method on the `App\Models\User` model instance. The createToken method accepts the name of the token as its first argument and an optional array of scopes as its second argument:
````php
use App\Models\User;
 
$user = User::find(1);
 
// Creating a token without scopes...
$token = $user->createToken('Token Name')->accessToken;
 
// Creating a token with scopes...
$token = $user->createToken('My Token', ['place-orders'])->accessToken;
````

> now your `Personal Access Tokens` will works with both `middleware(['client.credential'])` & `middleware(['auth:api'])`


# Token Scopes
Scopes allow your API clients to request a specific set of permissions when requesting authorization to access an account. For example, if you are building an e-commerce application, not all API consumers will need the ability to place orders. Instead, you may allow the consumers to only request authorization to access order shipment statuses. In other words, scopes allow your application's users to limit the actions a third-party application can perform on their behalf.


#### Defining Scopes
You may define your API's scopes using the `Passport::tokensCan()` method in the boot method of your application's `App\Providers\AuthServiceProvider` class. The tokensCan method accepts an array of scope names and scope descriptions. The scope description may be anything you wish and will be displayed to users on the authorization approval screen:
````php
/**
 * Register any authentication / authorization services.
 */
public function boot(): void
{
    Passport::tokensCan([
        'place-orders' => 'Place orders',
        'check-status' => 'Check order status',
    ]);
}
````

### Assigning Scopes To Tokens
#### When Requesting Authorization Codes
When requesting an access token using the authorization code grant, consumers should specify their desired scopes as the scope query string parameter. The scope parameter should be a space-delimited list of scopes:
````php
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 'client-id',
        'redirect_uri' => 'http://example.com/callback',
        'response_type' => 'code',
        'scope' => 'place-orders check-status',
    ]);
 
    return redirect('http://passport-app.test/oauth/authorize?'.$query);
});
````


### Checking Scopes
Passport includes two middleware that may be used to verify that an incoming request is authenticated with a token that has been granted a given scope. To get started, add the following middleware to the `$middlewareAliases` property of your `app/Http/Kernel.php` file:
````php
'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
````


### Check For All Scopes
The scopes middleware may be assigned to a route to verify that the incoming request's access token has all the listed scopes:
````php
Route::get('/orders', function () {
    // Access token has both "check-status" and "place-orders" scopes...
})->middleware(['auth:api', 'scopes:check-status,place-orders']);
````

### Check For Any Scopes
The scope middleware may be assigned to a route to verify that the incoming request's access token has at least one of the listed scopes:
````php
Route::get('/orders', function () {
    // Access token has either "check-status" or "place-orders" scope...
})->middleware(['auth:api', 'scope:check-status,place-orders']);
````

### Checking Scopes On A Token Instance
Once an access token authenticated request has entered your application, you may still check if the token has a given scope using the tokenCan method on the authenticated `App\Models\User` instance:
````php
use Illuminate\Http\Request;
 
Route::get('/orders', function (Request $request) {
    if ($request->user()->tokenCan('place-orders')) {
        // ...
    }
});
````