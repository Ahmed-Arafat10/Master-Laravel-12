all of your APIs routes in `routes` > `api.php`
````php
Route::post('/makeAttendance/', [StudentController::class, 'MakeAttendanceAPI']);
````

- Now to access this endpoint, in PostMan create new request with type `POST` with endpoint URL
 `http://127.0.0.1:8000/api/makeAttendance/`
- In body select raw then type JSON format to add JSON variables in Request body
````json
{
    "student_name" : "ARAFAT",
    "student_id" : 202201234,
    "meeting_id" : 17
}
````

- Method `MakeAttendanceAPI()` in `StudentController::class`
````php
public function MakeAttendanceAPI(StudentFormRequest $request)
    {
        $Val = Attendance::create([
            'Student_Name' => $request->student_name,
            'Student_ID' => $request->student_id,
            'Meeting_ID' => $request->meeting_id,
            'IP_Address' => $request->ip(),
            'Date' => Carbon::now()->format("Y-m-d h:i:s")
        ]);
        // If inserted successfully
        if ($Val) return response()->json([
            'msq' => 'Done Inserting The Attendance',
             'data' => Attendance::paginate(5)
        ], 200);
        // Otherwise
        else return response()->json([
            'msq' => 'An Error Occurred Try Again'
        ], 200);
    }
````

- In `StudentFormRequest.php`
````php
<?php

namespace App\CIC\Student\Requests;

use App\CIC\Student\Services\StudentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  $this->is('api/makeAttendance'); // Determine if the current request URI matches a pattern.Parameters:
        //return  $this->is('api/*'); // Any request contains `api/`
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Rules for 'api/makeAttendance' api
        if ($this->is('api/makeAttendance'))
            return [
                'student_name' => 'required',
                'student_id' => 'required|integer|digits:9',
                'meeting_id' => 'required|integer'
            ];
    }

    public function messages()
    {
        // Messages for 'api/makeAttendance' api
        if ($this->is('api/makeAttendance'))
            return [
                'student_name.required' => 'Please Enter Your Name',
                'student_id.required' => 'Please Enter Your ID',
                'student_id.integer' => 'Only Numbers (Positive) Are Allowed',
                'student_id.digits' => 'Please Add 0 To Your ID, Exp: 20190xxxx (Should Be 9 Digit Number)',
                'meeting_id.required' => 'required|integer',
                'meeting_id.integer' => 'required|integer'
            ];
    }
    
    
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->is('api/makeAttendance'))
            throw new HttpResponseException(response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422));
            
            
         # This is the body of this method in super class FormRequest
         # so, we are overriding it to send JSON response instead with errors 
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

}
````
> Must add `failedValidation()` method so that when any rule fails 
> instead of redirecting to page that contains `<form>` it will
> send JSON response instead with errors message

- If any rule failed the JSON response:
````json
{
    "message": "The given data was invalid.",
    "errors": {
        "meeting_id": [
            "required|integer"
        ]
    }
}
````


- If the data is correct, JSON response:
````json
{
    "msq": "Done Inserting The Attendance",
    "data": {
        "current_page": 1,
        "data": [
            {
                "ID": 12,
                "Student_Name": "Amr Hany Helmy",
                "Student_ID": 20206316,
                "Meeting_ID": 7,
                "Date": "2022-11-21 14:55:41",
                "IP_Address": null
            },
            {
                "ID": 14,
                "Student_Name": "muhib khaled ",
                "Student_ID": 20206762,
                "Meeting_ID": 1,
                "Date": "2022-11-27 08:16:56",
                "IP_Address": null
            },
            {
                "ID": 15,
                "Student_Name": "Aseel Motea",
                "Student_ID": 20206789,
                "Meeting_ID": 1,
                "Date": "2022-11-27 08:17:04",
                "IP_Address": null
            },
            {
                "ID": 16,
                "Student_Name": "Amr Hany Helmy",
                "Student_ID": 20206316,
                "Meeting_ID": 1,
                "Date": "2022-11-27 08:17:41",
                "IP_Address": null
            },
            {
                "ID": 17,
                "Student_Name": "Mohamed medhat mohamed",
                "Student_ID": 20206408,
                "Meeting_ID": 1,
                "Date": "2022-11-27 08:17:43",
                "IP_Address": null
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/makeAttendance?page=1",
        "from": 1,
        "last_page": 199,
        "last_page_url": "http://127.0.0.1:8000/api/makeAttendance?page=199",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=3",
                "label": "3",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=4",
                "label": "4",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=5",
                "label": "5",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=6",
                "label": "6",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=7",
                "label": "7",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=8",
                "label": "8",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=9",
                "label": "9",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=10",
                "label": "10",
                "active": false
            },
            {
                "url": null,
                "label": "...",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=198",
                "label": "198",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=199",
                "label": "199",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/makeAttendance?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://127.0.0.1:8000/api/makeAttendance?page=2",
        "path": "http://127.0.0.1:8000/api/makeAttendance",
        "per_page": 5,
        "prev_page_url": null,
        "to": 5,
        "total": 991
    }
}
````