<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = \App\Comment::paginate(15);
        return new \App\Http\Resources\CommentsResource($comments);
    }

    public function comments($id) {
        $post = \App\Post::find($id);
        $comments = $post->comments()->paginate(15);
        return new \App\Http\Resources\CommentsResource($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
      $request->validate([
        'content' => 'required',
      ]);

      $user = $request->user();
      $comment = new \App\Comment;
      $comment->content = $request->get('content');
      $comment->post_id = intval($id);
      $comment->date_written = now()->format('Y-m-d H-i-s');
      $comment->user_id = $user->id;

      $comment->save();

      return new \App\Http\Resources\CommentResource($comment);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = \App\Comment::find($id);
        return new \App\Http\Resources\CommentResource($comment);
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

      $user = $request->user();
      $comment = \App\Comment::find($id);

      if($request->has('content')) {
        $comment->content = $request->get('content');
      }

      if($request->has('post_id')) {
        $comment->post_id = intval($request->get('post_id'));
      }

      $comment->save();

      return new \App\Http\Resources\CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $comment = \App\Comment::find($id);
      $comment->delete();
      return new \App\Http\Resources\CommentResource($comment);
    }
}
