<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'quantity',
        'subtotal',
        'status',
        'user_id',
        'created_at',
    ];
}
