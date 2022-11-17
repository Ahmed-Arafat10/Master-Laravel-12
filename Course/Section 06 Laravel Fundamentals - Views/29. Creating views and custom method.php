<?php

# All of the views in laravel are in `resource` > `views`
# Also you can a folder and put inside it views file
# as we said before views are representation of your page, like HTML CSS JS and so on
# extension of view is  `.blade.php` blade is a template engine that allows us to write shortcut code of php (we will see an example)
# create a file called `contact.blade.php` in `view` folder & then write in it HTML
# Create a function in your controller file that return a view called `contact`

function ContactPage()
{
    return view('contact');
}

# then in `web.app` file write following route to call ContactPage() function from `PostController` file
Route::get('/contact',[PostController::class,'ContactPage']);


# now whatever request is sent to `/contact` path it will call ContactPage() that will return the view which is called `contact`

