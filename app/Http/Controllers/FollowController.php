<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user)
    {
        if ($user->id == auth()->user()->id) {
            return back()->with('you cant  follow urself');
        }

        $existCheck = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', auth()->user()->id]])->count();

        if ($existCheck) {
            return back()->with('failure', 'u already following');
        }

        // You cant follow yourself,
        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'user is successfully followed');
    }

    public function removeFollow(User $user)
    {
        Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->delete();
        return back()->with('success', 'User successfully unfollowed.');
    }
}
