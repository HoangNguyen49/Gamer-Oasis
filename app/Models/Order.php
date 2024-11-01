<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // Tên bảng
    protected $primaryKey = 'order_id'; // Khóa chính
    public $incrementing = true; // Chỉ định rằng khóa chính là số nguyên tự tăng

    use HasFactory;

    protected $fillable = [
        'product_name',
        'quantity',
        'subtotal',
        'status',
        'user_id',
        'created_at',
    ];

    // Định nghĩa quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'Product_id'); // 'product_id' là khóa ngoại trong bảng orders
    }
}
