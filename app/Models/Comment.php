<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [
        'post_id',
        'user_id',
        'text',
        'comment_id',
    ];

    protected $with = [
        'user',
        'comment'
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    public function post ()
    {
        return $this->belongsTo(Post::class);
    }
    public function comment ()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
