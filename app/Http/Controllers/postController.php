<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class postController extends Controller
{

    private function redirectToHome($type = 'success', $message = null){
        return redirect('/')->with($type, $message);

    }

    public function destroy(Post $post){
        if (Auth::id() === $post->user_id) {
           $post->delete();
    }

        return $this->redirectToHome('success', 'Post deleted successfully!');
    }

    public function update(Request $request, Post $post){
        if (Auth::id() !== $post->user_id) {
            return $this->redirectToHome('error', 'You are not authorized to update this post.');
    }
    
        $incomingFields = $request->validate([
            'title' => 'required|min:5|max:100',
            'body' => 'required|min:10|max:1000'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return $this->redirectToHome('success', 'Post updated successfully!');
        //return redirect('/')->with('success', 'Post updated successfully!');
    }

    public function edit(Post $post){
        if (Auth::id() !== $post->user_id) {
            return $this->redirectToHome('error', 'You are not authorized to edit this post.');
    }
    return view('edit', ['post' => $post]);
}
    public function showPosts(){
        //Toavoid error if user is not authenticated
        $posts = [];
        if (Auth::check()) {
        //Get posts for the authenticated user
        $posts = auth::user()->posts()->latest()->get();
        }
        //It begins from the pespective of block Post
        //$posts = Post::where('user_id', Auth::id())->get();
        return view('post', ['posts' => $posts]);
    }

    public function message(){
        return view('message');
    }

    public function createPost(Request $request){
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to create posts.');
        }

        $incomingFields = $request->validate([
            'title' => 'required|min:5|max:100',
            'body' => 'required|min:10|max:1000'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::id();

        Post::create($incomingFields);

        return $this->redirectToHome('success', 'Post created successfully!');
        //return redirect('/')->with('success', 'Post created successfully!');
    }
}
