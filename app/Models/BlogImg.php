<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImg extends Model
{
    use HasFactory;

    protected $table = 'blog_imgs';

    protected $fillable = [
        'blog_id',
        'img',
    ];

    // Định nghĩa mối quan hệ với Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
