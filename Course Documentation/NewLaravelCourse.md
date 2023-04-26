- In `test.blade.php` you can directly output `$id` like this `{{ $id }}`
- Without passing it to test view as it is URL GET Variable
````php
Route::get('/new1/{id}', function ($id) {
    return view('test');
});
````
> Not Working

- To Access GET URL Variables in your `view` you have many methods
````php
# get id from route URL method #1
{{ Request::route('id') 
# get id from route URL method #2
{{ request()->route()->parameter('id') }}
# get id from route URL method #3
{{ request()->id; }}
# returns an array of all parameters of the current route
{{ request()->route()->parameters(); }}
# returns an array of all parameters Names (numeric index refers to parameter name)
{{ request()->route()->parameterNames(); }}
````

- You can pass an array to `compact()` function like this
````php
Route::get('/new2/{id}', function ($id) {
    return view('test', compact([$id => 'id']));
});
````

- Second parameter is sent to `@yield('title')`
````php
@section('title','K-Hub Home Page'),
````
> `'K-Hub Home Page'` is the parameter sent to `@yield('title')`

- Insert a new row in Query Builder
````php
DB::table('xyz')->insert([
'key' => 12
]);
````

- Update a row in Query Builder
````php
DB::table('xyz')->where('id',12)->update([
        'key' => 12
]);
````

- Delete row in Query Builder
````php
DB::table('xyz')->where('id',12)->delete();
````

- Go to previous request
````php
redirect()->back();
````

- In `PostRequest.php` if I want to add a custom message
````php
public function messages()
{
    # title -> form input name
    # required -> rule name
    return [
    'title.required' => 'My Friend, This Field Is Required',
    'title.min' => 'My Friend, This Field Is Min',
    'title.max' => 'My Friend, This Field Is Min',
    'title.unique' => 'My Friend, This Field Is Min',
        ];
}
````

- To display error under a `<input>` for example in your view
````php
@error('field-name')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
````



- Print generated CRSF value
````php
{{ csrf_token() }}
````

- Generate a hidden input with name _token with value = to csrf token generated
````php
{{ csrf_field() }}
````

<hr>
<hr>

- In Meeting Model
````php
public function Attendance($date)
    {
        return $this->hasMany(Attendance::class, 'Meeting_ID')
            ->where('Date', 'LIKE', $date)
            ->get();
    }
````

- In Route
````php
Route::get('/yes/{Meeting_id}', function ($Meeting_id) {
    $s = Meetings::findOrFail($Meeting_id)
        ->Attendance('%2022-11-27%');
    //return dd($s);
    foreach ($s as $k => $item) {
        echo $k . $item . '<pre>';
    }
});
````



- In Meeting Model
````php
public function Attendance()
{
        return $this->hasMany(Attendance::class, 'Meeting_ID');
}
````


- In Route
````php
Route::get('/yes/{MeetingID}/{StudentID}', function ($MeetingID, $StudentID) {
    $s = Meetings::with(['Attendance' => function ($q) use ($StudentID) {
            $q->where('Student_ID', $StudentID)
            ->where('Date', 'LIKE', '%2022-11-27%');
        }])->where('ID', $MeetingID)->get();
    return dd($s[0]->Attendance[0]->Student_Name);
})->whereNumber(['MeetingID'])
->where(['StudentID' => '[0-9]+'])
->name('GetStudentAttendingSpecificMeeting');
````


````php
php artisan storage:link
````


- To retrieve the validated data from the $request object, you can call the $request->validated() method. This method returns an array of the validated data.
````php
$request->validated();
````

### Note that if the rules specified in form request are not obeyed, then the rest of the controller method will not automatically execute

in Form Request
````php
public function rules()
    {
        if($this->route()->getActionMethod() == 'SignIn')
        return [
            'DoctorName' => 'required',
            'MeetingPassword' => 'required',
        ];

        if($this->route()->getActionMethod() == 'MakeAttendance')
            return [
                'DoctorName' => 'required',
                'MeetingPassword' => 'required',
            ];
    }
````

in Form Request
````php
public function messages()
    {
        if ($this->route()->getActionMethod() == 'SignIn')
            return [
                'DoctorName.required' => 'Please Enter Dr. Name',
                'MeetingPassword.required' => 'Please Enter Meeting\'s password'
            ];

        if ($this->route()->getActionMethod() == 'MakeAttendance')
            return [
                'student_name.required' => 'Please Enter Your Name',
                'student_id.required' => 'Please Enter Your ID',
                'student_id.integer' => 'Only Numbers (Positive) Are Allowed',
                'student_id.digits' => 'Please Add 0 To Your ID, Exp: 20190xxxx (Should Be 9 Digit Number)',
            ];
    }
````


## ChatGPT: add unique rule for column value
- In Laravel, you can create a custom validation rule that checks if the input value is unique in the specified database table except for the current record being edited. Here's an example:
````php
use Illuminate\Validation\Rule;

public function rules()
{
    $id = $this->route('id'); // get the current record ID from the route parameters
    $tableName = 'users'; // replace with the name of your database table
    $columnName = 'email'; // replace with the name of the column you want to validate

    return [
        'email' => [
            'required',
            'email',
            Rule::unique($tableName, $columnName)->ignore($id, 'id'),
        ],
    ];
}
````
> In this example, we use the `Rule::unique()` method to create a validation rule that checks if the input value is unique in the users table, except for the record with ID $id. The ignore() method tells Laravel to ignore the record with the specified ID when checking for uniqueness. The second argument to ignore() specifies the name of the primary key column in the table, which is id in this example.

> Note that you need to replace users and email with the name of your database table and column name, respectively. Also, you need to make sure that the route parameter name matches the one used in the ignore() method.

>The `ignore()` method is used in a Laravel validation rule to tell the validator to ignore a specific record when checking for uniqueness.
For example, when editing an existing record, you want to allow the user to update the record without triggering a validation error for a field that already exists in the database. Without using ignore(), the validation rule would always return an error because the existing record in the database matches the updated value.
So, by passing the ID of the current record to the `ignore()` method, Laravel knows to ignore that record when checking for uniqueness, allowing the user to update the record without triggering a validation error.


## ChatGPT: different between store() and storeAs()
- In Laravel, both store() and storeAs() methods are used to store uploaded files, but they differ in how they handle the filename of the stored file.
The store() method is used to store the uploaded file with its original filename. For example, if the uploaded file has a filename of example.jpg, the store() method will store it with the same filename in the specified directory.
````php
$path = $request->file('file')->store('public');
````
> In this example, the uploaded file will be stored in the public directory with its original filename.
On the other hand, the storeAs() method allows you to specify a custom filename for the stored file. For example, if you want to store the uploaded file with a specific filename like myfile.jpg, you can use the storeAs() method:

````php
$path = $request->file('file')->storeAs('public', 'myfile.jpg');
````
> In this example, the uploaded file will be stored in the public directory with the filename myfile.jpg. If a file with the same name already exists in the directory, it will be overwritten.
In summary, the store() method is used when you want to store the uploaded file with its original filename, while the storeAs() method is used when you want to specify a custom filename for the stored file.


- All you need to know to upload a file

````php
<body>
<form method="POST"
      action="{{ route('uploadimage') }}"
      enctype="multipart/form-data">
    @csrf

    <input type="file" name="ImageInput" value="{{ old('ImageInput') }}">
    <button type="submit">Click Me</button>
</form>
{{ Shared::ShowAllErrors($errors)}}
</body>
````

- In Controller :
````php
public function UploadImage(StudentFormRequest $request)
    {
        //echo $request->file('ImageInput')->getClientOriginalName() . '<br>'; // ging.png
        //echo $request->file('ImageInput')->getClientMimeType() . '<br>'; // image/png   application/x-msdownload
        //echo $request->file('ImageInput')->getClientOriginalExtension() . '<br>'; // png
        //echo $request->ImageInput->extension(); // other way to get extension of a file
        //echo $request->file('ImageInput')->getPathname() . '<br>'; // C:\xampp\tmp\php551A.tmp
        //echo $request->file('ImageInput')->getPath() . '<br>'; // C:\xampp\tmp\
        //echo $request->file('ImageInput')->getFilename() . '<br>'; // php139B.tmp
        //echo $request->file('ImageInput')->getSize(); // 101936
        //echo $request->file('ImageInput')->getType();
        //echo $request->hasFile('ImageInput'); // boolean
        # make sure image name is valid, no : or - or spaces
        $NewName = Carbon::now()->format('Y_m_d_h_i_s_') . $request->file('ImageInput')->getClientOriginalName();
        //echo $NewName;
        $path = $request->file('ImageInput')->storeAs('public/Images', $NewName);
        $path = $request->file('ImageInput')->store('public/Images');
        if ($path === false) echo "Something Went Wrong";
    }
````


## ChatGPT : `failedValidation()`
- `failedValidation()` is a method in `Laravel`'s Form Request class that is called if validation rules fail. You can override this method in your custom Form Request class to customize the response when validation fails, for example, by returning a custom error message or redirecting the user back with old input values.
You can use this method to perform custom actions when validation fails. For example, you might want to log the error or send an email notification to an administrator. The `$validator` parameter in the `failedValidation()` method contains the validator instance, so you can access any validation errors or input data that was submitted with the request.
````php
    protected function failedValidation(Validator $validator)
    {
        $response = redirect()->route('ViewHome');
        $response = redirect()
            ->route('ViewHome')
            ->withErrors($validator->errors())
            ->withInput(['file' => $this->file('ImageInput')->getClientOriginalName()]);
        throw new HttpResponseException($response);
    }
````

## ChatGPT : `authorize()` in `FormRequest` 
- In Laravel 9, the authorize() method in a form request is used to authorize the incoming request before the request is validated and processed by the controller.
When a form request is instantiated, Laravel will automatically call the authorize() method. If the authorize() method returns false, Laravel will automatically abort the request with a 403 Forbidden response. If the authorize() method returns true, Laravel will continue processing the request.
The authorize() method in a form request is often used to check if the authenticated user is authorized to perform the action requested by the incoming request. For example, if a user is trying to update a post, the authorize() method can check if the authenticated user is the owner of the post or has the necessary permissions to update the post.
````php
public function authorize()
    {
        return StudentService::Auth();
    }
````
> If true then proceed the request otherwise show page 403 THIS ACTION IS UNAUTHORIZED.



## ChatGPT : How to make Two Guards for admin & user
To create separate authentication guards for admin and user in Laravel 9, you can follow these steps:

1. Define two different authentication guards in the `config/auth.php` file. You can define multiple authentication guards in Laravel, each with its own driver and user provider.

Here's an example of how to define two guards named `admin` and `user`:

```php
'guards' => [
    'admin' => [
        'driver' => 'session',
        'provider' => 'admin_users',
    ],

    'user' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],
```

In the example above, we define two guards, one for `admin` and another for `user`. Each guard has its own driver and user provider.

2. Define two different authentication providers for `admin` and `user` in the `config/auth.php` file. You can define multiple authentication providers in Laravel, each with its own driver and model.

Here's an example of how to define two providers named `admin_users` and `users`:

```php
'providers' => [
    'admin_users' => [
        'driver' => 'eloquent',
        'model' => App\Models\AdminUser::class,
    ],

    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

In the example above, we define two providers, one for `admin_users` and another for `users`. Each provider has its own driver and model.

3. Use the `auth` middleware to protect routes based on the specific guard that you want to use. You can use the `auth:guard` middleware to specify which guard should be used to authenticate the user.

Here's an example of how to use the `auth` middleware for protecting routes based on the specific guard:

```php
Route::group(['middleware' => ['auth:admin']], function () {
    // routes for admin users
});

Route::group(['middleware' => ['auth:user']], function () {
    // routes for regular users
});
```

In the example above, we use the `auth:admin` middleware to protect routes for admin users, and `auth:user` middleware to protect routes for regular users.

4. Use the `Auth::guard()` method to switch between the two guards. You can use the `Auth::guard()` method to switch between guards when you need to authenticate a user.

Here's an example of how to use the `Auth::guard()` method to switch between guards:

```php
// Authenticate admin user
Auth::guard('admin')->attempt($credentials);

// Authenticate regular user
Auth::guard('user')->attempt($credentials);
```
In the example above, we use the `Auth::guard()` method to switch between guards to authenticate a user based on the specific guard.
<hr>


You can use a named route with the `redirect()->intended()` method by passing the named route as an argument to the method. Here's an example:

```php
use Illuminate\Http\Request;

Route::get('/dashboard', function (Request $request) {
    // This page requires authentication
    // If the user is not authenticated, Laravel will redirect them to the login page
    // After the user logs in, they will be redirected back to this page
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login', function () {
    // This is the login page
    return view('login');
});

Route::post('/login', function (Request $request) {
    // Check if the user's credentials are valid
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // If the user's credentials are valid, redirect them back to the originally requested URL
        return redirect()->intended(route('dashboard'));
    } else {
        // If the user's credentials are invalid, redirect them back to the login page with an error message
        return redirect('/login')->with('error', 'Invalid credentials');
    }
});
```
> In the example above, the `/dashboard` route is named `dashboard` using the `name()` method. When the user is redirected back to the originally requested URL after logging in, we pass the named route `dashboard` as an argument to the `route()` function. The `route()` function generates the URL for the named route.
> Note that the named route must exist in your application's routes file, and you should make sure that the named route corresponds to the URL that the user originally requested.





- To check if a table already exists (to prevent error when executing `php artisan serve`), as it executes the commands again
````php
if (!Schema::hasTable('admin'))
````


- To check if one column already exists in a table
````php
if(!Schema::hasColumn('meetings','password'))
````
> Pass table name then column name


- To check if some columns already exist in a table
````php
if (!Schema::hasColumns('attendance', ['Date', 'IP_Address']))
````
> Pass table name then column names in an array


- Encrypt `.env` file
````php
php artisan env:encrypt
````

- Decrypt `.env` file
````php
php artisan env:decrypt --key=base64:ifcek+9qNo3BMqslL8EgXoC2KB9winAzrghVneNWAAY=
````

- To view Laravel Documentation
````php
php artisan docs
````

<hr>

> #### Update a project from 9.x to 10, Link : [Click Me](https://blog.devgenius.io/how-to-upgrade-from-laravel-9-x-to-laravel-10-x-926b826b454f)

<hr>


## Mails In Laravel

- In `.env` file:
````php
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=YourMail
MAIL_PASSWORD=YourPassword
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="YourMail"
MAIL_FROM_NAME="${APP_NAME}"
````

- Create new mail class
````php
php artisan make:mail welcome
````

- In `app` > `Mail` > `welcome.php` :
````php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'TEST',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'AhmedArafat',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
````

-In route file:
````php
Route::get('/mail', function () {
    \Illuminate\Support\Facades\Mail::to('EmailAddress@gmail.com')
        ->send(new \App\Mail\welcome());
});
````


## Cache In Laravel
````php
use Illuminate\Support\Facades\Cache;
use App\Models\Attendance;

Route::get('/makecache', function () {
/*
get
put
forget
flush
forever
remember
rememberForever
 */
Cache::remember('attendance', 10, function () {
return Attendance::orderBy('Date', 'DESC')->get();
});

});
Route::get('/cache', function () {
return Cache::get('attendance');
});
````




### Search For
1. route group
2. switch blade
3. fillable & hidden
4. {{ }} and {!! !!}
