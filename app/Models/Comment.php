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
    ];

    protected $with = [
        'user',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    public function post ()
    {
        return $this->belongsTo(Post::class);
    }
}
