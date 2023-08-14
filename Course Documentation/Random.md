- Create a column then make it `FK`
````php
$table->foreignId('blog_cat_id')
                    ->constrained('id')
                    ->onDelete('cascade');
````

- make a column required
````php		
$table->string('title')->required();
````

- view a 403 page:
````php
return abort(403);				
````


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


- put your website in maintenance mode
````php
php artisan down // maintenance mode ON
php artisan up // maintenance mode OFF
````

- Make page refresh every 15 mit.
````php
php artisan down --refresh=15 // maintenance mode ON for 15min
````

