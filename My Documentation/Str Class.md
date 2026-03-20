The Str::random method generates a random string of the specified length. This function uses PHP's random_bytes function:
````php
use Illuminate\Support\Str;
 
$random = Str::random(40);
````


The slug method generates a URL friendly "slug" from the given string:
````php
use Illuminate\Support\Str;
 
$slug = Str::of('Laravel Framework')->slug('-');
 
// laravel-framework
````


The Str::mask method masks a portion of a string with a repeated character, and may be used to obfuscate segments of strings such as email addresses and phone numbers:
````php
use Illuminate\Support\Str;
 
$string = Str::mask('taylor@example.com', '*', 3);
 
// tay***************
````

If needed, you provide a negative number as the third argument to the mask method, which will instruct the method to begin masking at the given distance from the end of the string:
````php
$string = Str::mask('taylor@example.com', '*', -15, 3);
 
// tay***@example.com
````