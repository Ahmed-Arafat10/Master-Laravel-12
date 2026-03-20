- How to use `Enum` in a project
````php
<?php

namespace App\Enum;

enum UserRolesEnum: int
{
    case USER = 1;
    case ADMIN = 2;
    case SUPER_ADMIN = 3;
}
````
> `UserRolesEnum::ADMIN->value` : 2 <br>
> `UserRolesEnum::ADMIN->name` : ADMIN