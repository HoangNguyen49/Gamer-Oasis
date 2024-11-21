<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'user_name',
        'user_email',
        'rating',
        'comment',
        'parent_id',
    ];
    protected $attributes = [
        'rating' => 0,
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public static function totalComments()
    {
        return self::count();
    }
    public function replies()
{
    return $this->hasMany(BlogComment::class, 'parent_id');
}
}
