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
        $NewName = Upload.mdCarbon::now()->format('Y_m_d_h_i_s_') . $request->file('ImageInput')->getClientOriginalName();
        //echo $NewName;
        $path = $request->file('ImageInput')->storeAs('public/Images', $NewName);
        $path = $request->file('ImageInput')->store('public/Images');
        if ($path === false) echo "Something Went Wrong";
    }
````



