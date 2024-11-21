<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    public $timestamps = false;
    protected $table = 'Product_Specifications';
    protected $primaryKey = 'Product_spec_id';
    protected $fillable = ['Product_id', 'Spec_name'];

    public function product() {
        return $this->belongsTo(Product::class, 'Product_id', 'Product_id');
    }
}

