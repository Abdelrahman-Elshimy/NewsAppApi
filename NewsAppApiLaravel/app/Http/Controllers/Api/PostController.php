<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class PostController extends Controller
{

    public function index()
    {
        $posts =  \App\Post::with(['comments', 'author', 'category'])->paginate(15);
        return new \App\Http\Resources\PostsResource($posts);
    }


    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required',
        'content' => 'required',
        'category_id' => 'required',
      ]);

      $user = $request->user();
      $post = new \App\Post;
      $post->title = $request->get('title');
      $post->content = $request->get('content');
      $post->category_id = intval($request->get('category_id'));
      $post->user_id = $user->id;

      $post->vote_up = 0;
      $post->vote_down = 0;
      $post->date_written = now()->format('Y-m-d H-i-s');

      // upload feature image

      if($request->hasFile('featured_image')) {
        $featuredImage = $request->file('featured_image');
        $filename = time().$featuredImage->getClientOriginalName();
        $path = '/public/images/';
        Storage::disk('local')->putFileAs(
          $path,
          $featuredImage,
          $filename
        );

        $post->featured_image = 'http://localhost/NewsAppApi/NewsAppApiLaravel/storage/app/public/images/'.$filename;
      }



      $post->save();

      return new \App\Http\Resources\PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = \App\Post::with(['comments', 'author', 'category'])->where('id', $id)->get();
        return new \App\Http\Resources\PostResource($post);
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


      $post = \App\Post::find($id);

      $user = $request->user();

      if($request->has('title')) {
        $post->title = $request->get('title');
      }

      if($request->has('content')) {
        $post->content = $request->get('content');
      }

      if($request->has('category_id')) {
        $post->category_id = intval($request->get('category_id'));
      }

      // upload feature image

      if($request->hasFile('featured_image')) {
        $featuredImage = $request->file('featured_image');
        $filename = time().$featuredImage->getClientOriginalName();
        $path = '/public/images/';
        Storage::disk('local')->putFileAs(
          $path,
          $featuredImage,
          $filename
        );

        $post->featured_image = 'http://localhost/NewsAppApi/NewsAppApiLaravel/storage/app/public/images/'.$filename;
      }



      $post->save();

      return new \App\Http\Resources\PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = \App\Post::where('id',$id)->first();
      $post->delete();
      return new \App\Http\Resources\PostResource($post);
    }
}
