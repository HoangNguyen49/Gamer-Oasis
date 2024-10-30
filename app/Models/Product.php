<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   
    use HasFactory;
    protected $table = 'Products';
    protected $primaryKey = 'Product_id';
    protected $fillable = ['Category_id', 'Brand_id', 'Product_name', 'Product_description', 'Price', 'Stock_Quantity', 'Slug'];

    public function category() {
        return $this->belongsTo(Category::class, 'Category_id', 'Category_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'Brand_id', 'Brand_id');
    }

    public function colors() {
        return $this->hasMany(ProductColor::class, 'Product_id', 'Product_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'Product_id', 'Product_id');
    }

    public function specifications() {
        return $this->hasMany(ProductSpecification::class, 'Product_id', 'Product_id');
    }
}

