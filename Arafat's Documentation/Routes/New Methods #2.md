## API Resource Routes
When declaring resource routes that will be consumed by APIs, you will commonly want to exclude routes that present HTML templates such as create and edit. For convenience, you may use the apiResource method to automatically exclude these two routes:
````php
use App\Http\Controllers\PhotoController;
 
Route::apiResource('photos', PhotoController::class);
````
You may register many API resource controllers at once by passing an array to the apiResources method:
````php
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;
 
Route::apiResources([
    'photos' => PhotoController::class,
    'posts' => PostController::class,
]);
````
> same, there is a method called `resources()`


## Nested Resources

Sometimes you may need to define routes to a nested resource. For example, a photo resource may have multiple comments that may be attached to the photo. To nest the resource controllers, you may use "dot" notation in your route declaration:
````php
use App\Http\Controllers\PhotoCommentController;
 
Route::resource('photos.comments', PhotoCommentController::class);
````
> This route will register a nested resource that may be accessed with URIs like the following: `/photos/{photo}/comments/{comment}`

### Shallow Nesting
Often, it is not entirely necessary to have both the parent and the child IDs within a URI since the child ID is already a unique identifier. When using unique identifiers such as auto-incrementing primary keys to identify your models in URI segments, you may choose to use "shallow nesting":
````php
use App\Http\Controllers\CommentController;
 
Route::resource('photos.comments', CommentController::class)->shallow();
````
````php

Verb	URI	Action	Route Name
GET	/photos/{photo}/comments	index	photos.comments.index
GET	/photos/{photo}/comments/create	create	photos.comments.create
POST	/photos/{photo}/comments	store	photos.comments.store
GET	/comments/{comment}	show	comments.show
GET	/comments/{comment}/edit	edit	comments.edit
PUT/PATCH	/comments/{comment}	update	comments.update
DELETE	/comments/{comment}	destroy	comments.destroy
````


### Naming Resource Routes
By default, all resource controller actions have a route name; however, you can override these names by passing a names array with your desired route names:
````php
use App\Http\Controllers\PhotoController;
 
Route::resource('photos', PhotoController::class)->names([
    'create' => 'photos.build'
]);
````

### Naming Resource Route Parameters
By default, Route::resource will create the route parameters for your resource routes based on the "singularized" version of the resource name. You can easily override this on a per resource basis using the parameters method. The array passed into the parameters method should be an associative array of resource names and parameter names:
````php
use App\Http\Controllers\AdminUserController;
 
Route::resource('users', AdminUserController::class)->parameters([
    'users' => 'admin_user'
]);
````
> The example above generates the following URI for the resource's show route: `The example above generates the following URI for the resource's show route:`