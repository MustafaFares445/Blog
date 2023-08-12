<?php

namespace App\services\PostServices;

use App\Models\Category;
use App\Models\PhotoPost;
use App\Models\Post;
use App\Models\Tag;
use App\Traits\ApiResponser;
use Exception;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\DB;

class StoringPostService
{
    use ApiResponser;

    function storePost($request)
    {


        try {
            DB::beginTransaction();

            $categoryId = Category::where('name' , $request->category)->get()[0]->id;

            $tagId = Tag::where('name' , $request->tag)->get()[0]->id;

            $post = Post::create([
                'author_id' => auth()->guard('author')->id(),
                'title' => $request->title,
                'content' => $request->content,
                'status' => Post::DEFAULT_STATUS,
            ]);

            $post->categories()->attach([$categoryId]);
            $post->tags()->attach([$tagId]);

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return $this->errorResponse($e->getMessage() , 400);
        }
        return $post;
    }

    function storePostPhotos($request , $postId) :void
    {
        foreach ($request->file('photo') as $photo){
            $postPhoto = new PhotoPost();
            $postPhoto->post_id = $postId;
            $postPhoto->photo = $photo->store('posts');
            $postPhoto->save();
        }

    }


    function store($request)
    {
        try {
            DB::beginTransaction();
            $post = $this->storePost($request);

            if ( $request->hasFile('photo') ) {
                $this->storePostPhotos($request , $post->id);
            }

            DB::commit();
            return $this->successResponse($post , 201);

        }catch (Exception $e){
            DB::rollBack();
            return $this->errorResponse($e->getMessage() , 400);
        }

    }
}
