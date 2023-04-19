<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'title',
        'text',
        'title_ru',
        'text_ru'
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
        return $this->hasMany(Comment::class)->latest();
    }
    public function getTitleAttribute($value)
    {
        $locale = App::getLocale();
        return json_decode($value)->$locale;
    }
    public function getTextAttribute($value)
    {
        $locale = App::getLocale();
        return json_decode($value)->$locale;
    }
}
