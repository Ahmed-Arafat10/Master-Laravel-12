- create markdown mailer class
````php
 php artisan make:mail test -m emails.test
````

- inside it
````php
public function content(): Content
    {
        return new Content(
            markdown: 'emails.test',
        );
    }
````

- to pass data
````php
   public function content(): Content
    {
        return new Content(
            markdown: 'emails.test', with: ['user' => $this->user]
        );

    }
````

- in created views > emails > test.blade.php
````php
<x-mail::message>
# Verify Your New Account

Please verify your new account by clicking on below button
hello {{$user->name}}
<x-mail::button :url="route('verify-email',$user->verification_token)">
Verify Your Account
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
````