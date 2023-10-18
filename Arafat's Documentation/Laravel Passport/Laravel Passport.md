## Laravel Passport

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
>   2016_06_01_000001_create_oauth_auth_codes_table ........................................................................................ 53ms DONE <br>
2016_06_01_000002_create_oauth_access_tokens_table ..................................................................................... 40ms DONE <br>
2016_06_01_000003_create_oauth_refresh_tokens_table .................................................................................... 49ms DONE <br>
2016_06_01_000004_create_oauth_clients_table ........................................................................................... 23ms DONE <br> 
2016_06_01_000005_create_oauth_personal_access_clients_table ........................................................................... 10ms DONE <br>
2019_08_19_000000_create_failed_jobs_table ............................................................................................. 23ms DONE <br>
2019_12_14_000001_create_personal_access_tokens_table .................................................................................. 28ms DONE <br>





-  This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens
````php
php artisan passport:install
````

    
- add the Laravel\Passport\HasApiTokens trait to your App\Models\User model. This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes. If your model is already using the Laravel\Sanctum\HasApiTokens trait, you may remove that trait
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

If you would like your client's secrets to be hashed when stored in your database, you should call the Passport::hashClientSecrets method in the boot method of your App\Providers\AuthServiceProvider class:
````php
    public function boot(): void
    {
        Passport::hashClientSecrets();
    }
````


By default, Passport issues long-lived access tokens that expire after one year. If you would like to configure a longer / shorter token lifetime, you may use the tokensExpireIn, refreshTokensExpireIn, and personalAccessTokensExpireIn methods. These methods should be called from the boot method of your application's App\Providers\AuthServiceProvider class
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





### client credential grant
Before your application can issue tokens via the client credentials grant, you will need to create a client credentials grant client. You may do this using the --client option of the passport:client Artisan command
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

to use this grant type, you may add the CheckClientCredentials middleware to the $middlewareAliases property of your application's app/Http/Kernel.php file
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



### password grant
The OAuth2 password grant allows your other first-party clients, such as a mobile application, to obtain an access token using an email address / username and password. This allows you to issue access tokens securely to your first-party clients without requiring your users to go through the entire OAuth2 authorization code redirect flow.

Before your application can issue tokens via the password grant, you will need to create a password grant client. You may do this using the passport:client Artisan command with the --password option. If you have already run the passport:install command, you do not need to run this command:
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


> [https://oauth2.thephpleague.com/](https://oauth2.thephpleague.com/) read article to know difference between client credential/ password / authorization code grant / refresh token grant
