- now I have to change the `$rules` in each `store()` & `update()` methods
- in `UserResource.php`:

````php
  private static array $attributes = [
        'User_ID' => 'id',
        'Name' => 'name',
        'Email' => 'email',
        'isVerified' => 'verified',
        'isAdmin' => 'admin',
        'creationDate' => 'created_at',
        'lastChange' => 'updated_at',
        'deletedDate' => 'deleted_at',
        'Password' => 'password'
    ];
````

> iam going to change the keys from `$request` object itself, observe the following

- now I want to change key of `$request` with the Model original attributes

````php
    public static function originalRequestAtt(Request &$request)
    {
        $res = [];
        foreach ($request->request->all() as $input => $val) {
            $k = static::originalAttribute($input);
            if($k) $res[$k] = $val;
        }
        $request->replace($res);
    }
````

> `$request->replace($res);` is used to Replace the input for the current request with new one <br>
> `$request->request->all()` : get data of request body only (input fields)