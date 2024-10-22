<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function index()
{
    $products = Product::with(['category', 'brand', 'images'])->get();
    return view('admin.pages.quanlisanpham', compact('products')); 
}

    public function create()
    {
    
    }

    public function store(Request $request)
    {
        
    }

  
    public function show(string $id)
    {
        
    }

    
    public function edit(string $id)
    {
        
    }

    
    public function update(Request $request, string $id)
    {
        
    }

    
    public function delete(string $id)
    {
        
    }
}
