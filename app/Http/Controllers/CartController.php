<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $brandId = $request->input('brand_id');
        $quantity = $request->input('quantity', 1);

        // Lấy thông tin sản phẩm từ model Product dựa trên brand_id
        $product = Product::with('images')->where('Brand_id', $brandId)->first();
        if (!$product) {
            return response()->json(['error' => 'Product does not exist'], 404);
        }

        // Lưu giỏ hàng trong session
        $cart = Session::get('cart', []);
        if (isset($cart[$brandId])) {
            $cart[$brandId]['quantity'] += $quantity;
        } else {
            $cart[$brandId] = [
                'brand_id' => $brandId,
                'product_name' => $product->Product_name,
                'price' => $product->Price,
                'quantity' => $quantity,
                'image' => $product->images->isNotEmpty() ? $product->images->first()->Image_path : 'path/to/default-image.jpg',
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => 'Product added to cart', 'cart' => $cart]);
    }
}
