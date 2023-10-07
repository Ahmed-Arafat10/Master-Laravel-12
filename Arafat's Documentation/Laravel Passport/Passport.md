#### GET `/oauth/clients`
This route returns all of the clients for the authenticated user. This is primarily useful for listing all of the user's
clients so that they may edit or delete them:

````php
php artisan passport:client
````

> with user ID 101

- when you are authorized in web (logged in) visit `http://127.0.0.1:8000/oauth/clients`

````php
[
  {
    "id": 3,
    "user_id": 101,
    "name": "arafat",
    "secret": "H5aryMJ8IoY9FDGZS7njEuxrw46a56ZaG7YilQij",
    "provider": null,
    "redirect": "http://localhost/auth/callback",
    "personal_access_client": false,
    "password_client": false,
    "revoked": false,
    "created_at": "2023-10-03T08:02:20.000000Z",
    "updated_at": "2023-10-03T08:02:20.000000Z"
  },
  {
    "id": 4,
    "user_id": 101,
    "name": "arafat 2",
    "secret": "3ePgXHzxzdv7FGgKyvilKgzhKQVkHB1h2v8IjyaG",
    "provider": null,
    "redirect": "http://localhost/auth/callback",
    "personal_access_client": false,
    "password_client": false,
    "revoked": false,
    "created_at": "2023-10-03T08:02:44.000000Z",
    "updated_at": "2023-10-03T08:02:44.000000Z"
  }
]
````

> these data are from `oauth_clients` table


````php
 GET|HEAD        oauth ........................................................................................................ generated::REMPV7l4X3z9gUtT  
  GET|HEAD        oauth/authorize ................................. passport.authorizations.authorize › Laravel\Passport › AuthorizationController@authorize  
  POST            oauth/authorize .............................. passport.authorizations.approve › Laravel\Passport › ApproveAuthorizationController@approve  
  DELETE          oauth/authorize ....................................... passport.authorizations.deny › Laravel\Passport › DenyAuthorizationController@deny  
  GET|HEAD        oauth/clients ....................................................... passport.clients.index › Laravel\Passport › ClientController@forUser  
  POST            oauth/clients ......................................................... passport.clients.store › Laravel\Passport › ClientController@store  
  PUT             oauth/clients/{client_id} ........................................... passport.clients.update › Laravel\Passport › ClientController@update  
  DELETE          oauth/clients/{client_id} ......................................... passport.clients.destroy › Laravel\Passport › ClientController@destroy  
  GET|HEAD        oauth/personal-access-tokens ................... passport.personal.tokens.index › Laravel\Passport › PersonalAccessTokenController@forUser  
  POST            oauth/personal-access-tokens ..................... passport.personal.tokens.store › Laravel\Passport › PersonalAccessTokenController@store  
  DELETE          oauth/personal-access-tokens/{token_id} ...... passport.personal.tokens.destroy › Laravel\Passport › PersonalAccessTokenController@destroy  
  GET|HEAD        oauth/scopes .............................................................. passport.scopes.index › Laravel\Passport › ScopeController@all  
  POST            oauth/token ......................................................... passport.token › Laravel\Passport › AccessTokenController@issueToken  
  POST            oauth/token/refresh ......................................... passport.token.refresh › Laravel\Passport › TransientTokenController@refresh  
  GET|HEAD        oauth/tokens .......................................... passport.tokens.index › Laravel\Passport › AuthorizedAccessTokenController@forUser  
  DELETE          oauth/tokens/{token_id} ............................. passport.tokens.destroy › Laravel\Passport › AuthorizedAccessTokenController@destroy  
````