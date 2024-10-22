<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'Product_images';
    protected $primaryKey = 'Image_id';
    protected $fillable = ['Product_id', 'Image_path', 'CreatedAt'];

    public function product() {
        return $this->belongsTo(Product::class, 'Product_id', 'Product_id');
    }
}

