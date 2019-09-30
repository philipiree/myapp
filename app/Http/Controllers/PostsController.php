<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;


class PostsController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        //$posts = Post:: orderBy('title', 'desc')->get();
        //return Post:: where('title', 'Post Two')->get();
        //$posts = Post::all();
        //$posts = Post:: orderBy('title', 'asc')->get();
        //DB use
        //$posts = DB:: select('SELECT * FROM posts');
        $posts = Post:: orderBy('title', 'desc')->paginate(10);

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
           'cover_image' => 'image|nullable|max:1999'
        ]);

        //handle file upload

        if($request ->hasFile('cover_image')){
          //Get filename with the extension
          $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
         //Get just filename
         $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
         //get Extension
         $extension = $request->file('cover_image')->getClientOriginalExtension();
         //Create filename to store : it will call the file name and extend it with timestamp to be unique
         $fileNameToStore = $fileName.'_'.time().'.'.$extension;
         //finally upload image
         $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }else{
            $fileNameToStore ='noimage.jpeg';
        }

        $post = new Post;
        $post ->title = $request->input('title');
        $post ->body = $request->input('body');
        $post ->user_id = auth()->user()->id;
        $post ->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post =  Post::find($id);
        return view('posts.show')->with('post', $post);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::find($id);
        //check if the same/correct user
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

        if($request ->hasFile('cover_image')){
          //Get filename with the extension
          $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
         //Get just filename
         $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
         //get Extension
         $extension = $request->file('cover_image')->getClientOriginalExtension();
         //Create filename to store : it will call the file name and extend it with timestamp to be unique
         $fileNameToStore = $fileName.'_'.time().'.'.$extension;
         //finally upload image
         $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }

        $post = Post::find($id);

        $post ->title = $request->input('title');
        $post ->body = $request->input('body');
         if($request ->hasFile('cover_image')){
             $post->cover_image = $fileNameToStore;
         }
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
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_image!= 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$post->cover_image);
        }

        $post ->delete();
        return redirect('/posts')->with('error', 'Post Removed');
    }

    public function cart($id){
         $post =  Post::find($id);
        return view('posts.cart')->with('post', $post);
    }

    public function bought($id){
        $post = Post::find($id);

    }

    public function updateNew(Request $request, $id)
    {

        $post = Post::find($id);

        $post ->title = $post ->title;
        $post ->body = $post ->body;
        $post ->user_id = auth()->user()->id;
        $post ->cover_image = $post ->cover_image;
        $post->save();

        return redirect('/dashboard')->with('success', 'Post Item Acquired');
    }

    /*if($request ->hasFile('cover_image')){
          //Get filename with the extension
          $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
         //Get just filename
         $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
         //get Extension
         $extension = $request->file('cover_image')->getClientOriginalExtension();
         //Create filename to store : it will call the file name and extend it with timestamp to be unique
         $fileNameToStore = $fileName.'_'.time().'.'.$extension;
         //finally upload image
         $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }

        $post = Post::find($id);

        $post ->title = $request->input('title');
        $post ->body = $request->input('body');
        $post ->user_id = auth()->user()->id;
         if($request ->hasFile('cover_image')){
             $post->cover_image = $fileNameToStore;
         }
        $post->save();

        return redirect('/dashboard')->with('success', 'Post Updated');
    }*/

}
