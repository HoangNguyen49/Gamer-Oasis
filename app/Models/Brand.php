<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'Brand';
    protected $primaryKey = 'Brand_id';
    protected $fillable = ['Brand_name', 'CreatedAt'];

    public function products() {
        return $this->hasMany(Product::class, 'Brand_id', 'Brand_id');
    }
}
