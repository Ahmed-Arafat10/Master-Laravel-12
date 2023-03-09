<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        $postLTS = Post::orderBy('updated_at', 'desc')->get();// Get all posts order by updated_at in descending order
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
    public function store(Request $request)
    {
        return "yes";
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
//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(string $id): Response
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, string $id): RedirectResponse
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(string $id): RedirectResponse
//    {
//        //
//    }
}
