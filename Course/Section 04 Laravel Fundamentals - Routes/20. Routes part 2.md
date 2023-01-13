<?php

# you can pass parameters in your URL using route like this:
# to add a get variable in URL type -> {VariableName}
# you have also to add a parameter to closure function
# it doesn't matter if these parameter having the same name as in URL or not
# but a good practicing is to have the same name so you don't be confused

Route::get('/posts/{id}',function ($id)
{
   return "Post number : " . $id;
});

# you can add more than one variable in URL, just add `/` between them

Route::get('/human/{age}/{name}',function ($age,$name)
{
    return "My name is " . $name . " My age is " . $age;
});