
````php
'email' => 'email|' . Rule::unique('users', 'email')->ignore($user->id)`
````
> Or `unique:users,email,' . $user->id`


````php
'admin' => Rule::in([User::ADMIN_USER, User::REGULAR_USER])
````
> Or `'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER` <br>
> `User::ADMIN_USER` is 1 & `User::REGULAR_USER` is 0
