<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'customer_email', 'contact_subject', 'contact_message'
    ];

    public $timestamps = true; // Sử dụng timestamps (created_at, updated_at)
}
