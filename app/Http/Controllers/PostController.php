<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Like;
use App\Comment;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $str = strtolower($request->title);
        $post->slug = preg_replace('/\s+/', '-', $str);
        $post->image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        #$like = Like::all()->where('post_id', $post->id);
        #$likes = count($like);

        $data = array(
            'post' => $post,
            'likes' => count($post->likes),
            'comments' => $post->comments
        );

        return view('posts.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();
        
        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/posts')->with('error', 'No Post Found');
        }

        // Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

         // Handle File Upload
        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        }

        // Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('image')){
            $post->image = $fileNameToStore;
        }
        $str = strtolower($request->title);
        $post->slug = preg_replace('/\s+/', '-', $str);
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/posts')->with('error', 'No Post Found');
        }

        // Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/images/'.$post->image);
        }
        
        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }

    public function like($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $user_id = auth()->user()->id;
        $checker = Like::where(['post_id'=>$post->id, 'user_id'=>$user_id])->first();

        if($checker){
            $checker->delete();
            return redirect(route('posts.show', $slug))->with('error','Post Disliked');
        }
        else{
            $like = new Like;
            $like->post_id = $post->id;
            $like->user_id = auth()->user()->id;
            $like->save();
            
            return redirect(route('posts.show', $slug))->with('success','Post Liked');
        }
    }

    public function comment(Request $request, $slug)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        
        $post = Post::where('slug', $slug)->first();
        $user_id = auth()->user()->id;

        // Create Comment
        $comment = new Comment;
        $comment->user_id = $user_id;
        $comment->post_id = $post->id;
        $comment->body = $request->input('body');
        $comment->save();

        return back()->with('success', 'Comment Successful');
    }
}
