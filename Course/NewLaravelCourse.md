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
    'title.required' => "My Friend, This Field Is Required",
    'title.min' => "My Friend, This Field Is Min",
    'title.max' => "My Friend, This Field Is Min",
    'title.unique' => "My Friend, This Field Is Min",
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
### Search For
1. route group
2. switch blade
3. fillable & hidden
4. {{ }} and {!! !!}
