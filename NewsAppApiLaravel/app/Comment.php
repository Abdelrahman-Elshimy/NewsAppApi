<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'date_written', 'user_id', 'post_id'];

    public function posts() {
        return $this->belongsTo(Post::class);
    }

    public function authors() {
        return $this->belongsTo(User::class);
    }
}
