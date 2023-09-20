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
