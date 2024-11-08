<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $primaryKey = 'coupon_id';

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'expiration_date',
    ];

    protected $dates = [
        'expiration_date',
    ];
}
