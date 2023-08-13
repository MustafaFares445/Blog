<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStatusRequest;
use App\Models\Post;
use App\Notifications\PostsNotifications;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    use ApiResponser;
    public function pendingPosts()
    {
        $posts = Post::where('status' , Post::DEFAULT_STATUS)->with('categories' , 'tags')->get();
        return $this->paginate($posts);
    }

    public function changeStatus(PostStatusRequest $request)
    {
        $post = Post::find($request->post_id);
        $post->update([
            'status' => $request->status ,
            'rejected_reason' => $request->rejected_reason
        ]);
        Notification::send($post->author , new PostsNotifications($post , $post->author));

        return $this->successResponse(["message" => "post status has been changed"]);
    }
}
