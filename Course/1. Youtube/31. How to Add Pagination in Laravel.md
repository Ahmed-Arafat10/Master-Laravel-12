- pagination means that instead of showing 1000 post in a single page, you can view only lets say 25 post per page 
- To do so instead of using `get()` method we will use method `paginate(25)` where number `25` is NumberOfRowsPerPage
- In `PostController`
````php
public function index()
    {
        $postLTS = Post::orderBy('updated_at', 'desc')->paginate(25);// Get all posts order by updated_at in descending order
        return view('blog.index', [
            'AllPosts' => $postLTS
        ]);
    }
````
- Now to add the part of pagination in the frontend, all you have to do it to add the method `links()`

````php
    <div style="margin: auto;padding-bottom: 10px; width: 10%" class="mx-auto pb-10 w-4/5">
        {{$AllPosts->links()}}
    </div>
````
> When you choose the page 3, a get query variable called `page` will appear in the URL, something like that `http://127.0.0.1:8000/blog?page=3`