- If you want to add a middleware for specific route
````php
Route::prefix('/blog')->middleware(['auth'])->group(function () {
    Route::get('/create', [PostController::class, 'create'])
        ->name('AddAPost');
    Route::get('/', [PostController::class, 'index'])
        ->name('ViewAllPosts');
    Route::get('/{id}', [PostController::class, 'show'])
        ->name('ShowSinglePost');
    Route::post('/', [PostController::class, 'store'])
        ->name('StoreANewPost');;
    Route::get('/edit/{id}', [PostController::class, 'edit'])
        ->name('GetPostToUpdate');
    Route::patch('/{id}', [PostController::class, 'update'])
        ->name('UpdateAPost');
    Route::delete('/{id}', [PostController::class, 'destroy'])
        ->name('DeleteAPost');
});
````

- A better method is that inside the controller itself add a constructor that
returns middleware auth with only specific method name
````php
public function __construct()
    {
        return $this->middleware('auth')->only(['create','edit','store','update','destroy']);
        //return $this->middleware('auth')->except();
    }
````
> now for all of the above methods, you will be redirected to login page if you are not authorized

- Now I have to hide some buttons (like New Article Button) if you are not authorized
````php
@if(Auth::user())
        <div class="py-10 sm:py-20">
            <a class="primary-btn inline text-base sm:text-xl bg-green-500 py-4 px-4 shadow-xl rounded-full transition-all hover:bg-green-400"
               href="{{route('AddAPost')}}">
                New Article
            </a>
        </div>
@endif
````
> `Auth:user()` get user model class of authorized user

- Now I want to show only edit and delete buttons with posts that have the same `user_id` as authorized user
````php
@if(Auth::id() === $SinglePost->user_id)
        <a
            href="{{ route('GetPostToUpdate',$SinglePost->id) }}"
            class="font-bold text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all py-20">
            Edit Post
        </a>
        <form
            action="{{ route('DeleteAPost',$SinglePost->id) }}"
            method="POST"
            class="font-bold text-green-500 italic hover:text-green-400 hover:border-b-2 border-green-400 pb-3 transition-all py-20">
            @csrf
            @method('DELETE')
            <button type="submit">Delete The Post</button>
        </form>
    @endif
````
> `Auth::id()` gets `id` of logged-in user