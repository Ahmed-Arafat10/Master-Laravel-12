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



- To retrieve the validated data from the $request object, you can call the $request->validated() method. This method returns an array of the validated data.
````php
$request->validated();
````
> Note that if the rules specified in form request are not obeyed, then the rest of the controller method will not automatically execute