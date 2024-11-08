<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'orders'; 

    protected $fillable = [
        'product_id',
        'product_name',
        'quantity',
        'subtotal',
        'status',
        'user_id',
        'full_name',
        'phone',
        'address',
        'email_address',
        'payment_method',
    ];

    
    public $timestamps = true;
}
