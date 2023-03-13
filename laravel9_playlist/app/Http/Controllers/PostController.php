<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post1 = Post::all(); // Retrieve all posts
        $post2 = Post::get(); // Retrieve all posts
        $post3 = Post::orderBy('id', 'desc')
            ->take(10)
            ->get(); // Retrieve last 10 posts
        $post4 = Post::where('min_to_read', 2)->get(); // Get posts where min_to_read = 2
        $post5 = Post::where('min_to_read', '!=', 2)->get();// Get posts where min_to_read != 2
        $post6 = Post::get()->count();// Count number of rows
        $post7 = Post::sum('min_to_read');// Get the sum
        $post8 = Post::avg('min_to_read');// Get the average
        $postLTS = Post::orderBy('updated_at', 'desc')->paginate(25);// Get all posts order by updated_at in descending order
        return view('blog.index', [
            'AllPosts' => $postLTS
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        //dd($request->all());// Get all the form data
        //dd($request->_token);// Get _token attribute from the form
//
//        # Method #1 using PHP OOP
//        # As you can see the name of the inputs are like the database column
//        $post = new Post();
//        $post->title = $request->title;
//        $post->excerpt = $request->excerpt;
//        $post->body = $request->body;
//        $post->image_path = 'temporary';
//        $post->is_published = $request->is_published === 'on';
//        $post->min_to_read = $request->min_to_read;
//        $post->user_id = 1;
//        $post->save();

        $request->validated();

        # Method #2 using Eloquent
        Post::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $this->storeImage($request),
            'is_published' => $request->is_published === 'on',
            'min_to_read' => $request->min_to_read,
            'user_id' => 1,
        ]);
        return redirect(route('ViewAllPosts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $SinglePostOld = Post::find($id);
        $SinglePost = Post::findOrFail($id);// Better as it will throw an exception (404 Not Found) when the `id` does not exist
        return view('blog.show', [
            'SinglePost' => $SinglePost
        ]);
    }
//

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('blog.edit', [
            'SinglePost' => Post::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        $request->validated();
        $arr = $request->except([
            '_token', '_method'
        ]);
        $arr['user_id'] = 1;
        Post::findOrFail($id)->update($arr);
        return redirect(route('ViewAllPosts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Post::destroy($id);
        return redirect(route('ViewAllPosts'))->with('message', 'Post Is Deleted Successfully');
    }

    private function storeImage(Request $request)
    {
        $newImage = uniqid() . '_' . $request->title . '.' . $request->image_path->extension();
        $request->image_path->move(public_path('images'), $newImage);
        return $newImage;
    }

    public function ShowAllPostsForAUser(int $id)
    {
        //dd($Allposts->posts);
        return view('blog.PostsForSpecificUser',[
            'AllPostsForThatUser' => User::findOrFail($id)->posts
        ]);
    }
}
