<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'title',
        'text',
    ];

    protected $with = [
        'comment',
        'user',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    public function comment ()
    {
        return $this->hasMany(Comment::class);
    }
}
