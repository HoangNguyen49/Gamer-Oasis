<?php

namespace App\Models; // Đảm bảo namespace là đúng

use Illuminate\Database\Eloquent\Model;

class VnpayOrder extends Model
{
    protected $table = 'vnpay_orders';

    protected $fillable = [
        'vnpay_id',
        'vnpay_orders_id',  
        'transaction_code',
        'amount',
        'status',
        'vnpay_response_code',
        'bank_code',
        'bank_transaction_code',
        'payment_type',
        'pay_date',
        'vnp_secure_hash',
    ];
}


