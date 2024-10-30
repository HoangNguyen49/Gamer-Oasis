<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'Category';
    protected $primaryKey = 'Category_id';
    protected $fillable = ['Category_name'];

    public function products() {
        return $this->hasMany(Product::class, 'Category_id', 'Category_id');
    }
}
