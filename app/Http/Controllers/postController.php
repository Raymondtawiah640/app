<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class postController extends Controller
{

    private function redirectToHome($type = 'success', $message = null){
        return redirect('/post')->with($type, $message);
    }

    public function search(Request $request){
        $searchTerm = $request->input('search');
        $posts = Post::where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('body', 'LIKE', "%{$searchTerm}%")
            ->paginate(5);
        return view('posts', ['posts' => $posts]);
    }

    public function destroy(Post $post){
        if (Auth::id() === $post->user_id) {
           $post->delete();
           return $this->redirectToHome('success', 'Post deleted successfully!');
        }

        return $this->redirectToHome('error', 'You are not authorized to delete this post.');
    }

    public function update(Request $request, Post $post){
        if (Auth::id() !== $post->user_id) {
            return $this->redirectToHome('error', 'You are not authorized to update this post.');
        }

        $incomingFields = $request->validate([
            'title' => 'required|min:5|max:100',
            'body' => 'required|min:10|max:300'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return $this->redirectToHome('success', 'Post updated successfully!');
    }

    public function edit(Post $post){
        if (Auth::id() !== $post->user_id) {
            return $this->redirectToHome('error', 'You are not authorized to edit this post.');
        }
        return view('edit', ['post' => $post]);
    }
   public function showPosts(Request $request){
        //To avoid error if user is not authenticated
        $posts = [];
        if (Auth::check()) {
            //Get posts for the authenticated user with pagination
            // Default to 5 posts per page, can be adjusted via request
            $perPage = $request->input('per_page', 5);

            $query = Auth::user()->posts()->latest();

            // Handle search functionality
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('body', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            $posts = $query->paginate($perPage);
        }
        //It begins from the perspective of block Post
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
            'body' => 'required|max:200'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::id();

        Post::create($incomingFields);

        return $this->redirectToHome('success', 'Post created successfully!');
        //return redirect('/')->with('success', 'Post created successfully!');
    }
}
