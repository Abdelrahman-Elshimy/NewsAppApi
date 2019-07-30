<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function index()
    {
        $posts = \App\Post::paginate(15);
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
      $post->featured_image = '';

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
        $post = \App\Post::find($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
