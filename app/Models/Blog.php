<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'description',
        'slug'
    ];

    public function images()
    {
        return $this->hasMany(BlogImg::class, 'blog_id');
    }
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }

    public static function totalBlogs()
    {
        return self::count();
    }

    public function totalRatingScore()
    {
        return $this->comments()->sum('rating');
    }
}
