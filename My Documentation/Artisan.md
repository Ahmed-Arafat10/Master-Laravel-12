- put your website in maintenance mode
````php
php artisan down // maintenance mode ON
php artisan up // maintenance mode OFF
````

- Make page refresh every 15 mit.
````php
php artisan down --refresh=15 // maintenance mode ON for 15min
````

- To view Laravel Documentation
````php
php artisan docs
````


- Encrypt `.env` file
````php
php artisan env:encrypt
````

- Decrypt `.env` file
````php
php artisan env:decrypt --key=base64:ifcek+9qNo3BMqslL8EgXoC2KB9winAzrghVneNWAAY=
````

````php
php artisan storage:link
````
