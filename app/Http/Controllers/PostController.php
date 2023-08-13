<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\PhotoPost;
use App\Models\Post;
use App\services\PostServices\StoringPostService;
use App\Traits\ApiResponser;
use Exception;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('status' , Post::APPROVED_STATUS)->with('categories' , 'tags')->get()->makeHidden('status');
        return $this->paginate($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        return (new StoringPostService())->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::whereId($id);

        return $this->successResponse($post->with('categories')->with('tags')->get());
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            DB::beginTransaction();

            $post->categories()->delete();
            $post->tags()->delete();
            $post->photos()->delete();
            $post->delete();

            DB::commit();
            return $this->successResponse("the Post has been deleted" , 200);
        }catch(Exception $e){
            return $this->errorResponse($e->getMessage() , $e->getCode());
        }

    }


}
