<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function actuallyUpdate(Post $post, Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully updated');
    }
    public function showEditForm(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }
    public function delete(Post $post)
    {
        $post->delete();

        return redirect('/profile/' . auth()->user()->username)->with('success', 'Successfully deleted');
    }
    public function viewSinglePost(Post $post)
    {
        $post['body'] = Str::markdown($post->body);
        return view('sing-post', ['post' => $post]);
    }

    public function showCreateForm()
    {

        return view('create-post');
    }

    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post successfuly created');
    }
}
