<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\User::paginate(10);
        return new \App\Http\Resources\UsersResource($users);
    }


    public function store(Request $request)
    {
        $request->validate([
          'name' => 'required',
          'email' => 'required',
          'password' => 'required',
        ]);

        $user = new \App\User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->save();

        return new \App\Http\Resources\UserResource($user);

    }

    public function getToken(Request $request){
      $request->validate([
        'email' => 'required',
        'password' => 'required'
      ]);

      $crediantials = $request->only('email', 'password');
      if(\Auth::attempt($crediantials)) {
        $user = \App\User::where('email', $request->get('email'))->first();
        return new \App\Http\Resources\TokenResource(['token' => $user->api_token]);
      }

      return 'Not Found';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::find($id);
        return new \App\Http\Resources\UserResource($user);
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

    public function posts($id) {
        $user = \App\User::find($id);
        $posts = $user->posts()->paginate(15);
        return new \App\Http\Resources\AuthorPostsResource($posts);
    }
    public function comments($id) {
        $user = \App\User::find($id);
        $comments = $user->comments()->paginate(15);
        return new \App\Http\Resources\AuthorCommentsResource($comments);
    }
}
