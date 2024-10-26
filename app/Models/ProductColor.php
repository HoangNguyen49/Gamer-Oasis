<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'Product_Colors';
    protected $primaryKey = 'Product_Colors_id';

    // Thêm 'Quantity' vào mảng $fillable
    protected $fillable = ['Product_id', 'Color_name', 'Quantity'];

    public function product() {
        return $this->belongsTo(Product::class, 'Product_id', 'Product_id');
    }
}


