<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $productId = $request->input('product_id');

        // Lấy thông tin sản phẩm từ model Product dựa trên product_id
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product does not exist !!!'], 404);
        }

        // Lưu danh sách yêu thích trong session
        $wishlist = Session::get('wishlist', []);
        if (!isset($wishlist[$productId])) {
            $wishlist[$productId] = [
                'product_id' => $productId,
                'product_name' => $product->Product_name,
                'price' => $product->Price,
                'image' => $product->images->isNotEmpty() ? $product->images->first()->Image_path : 'path/to/default-image.jpg',
                'stock_quantity' => $product->Stock_Quantity, // Lưu trữ stock_quantity
            ];

            Session::put('wishlist', $wishlist);

            return response()->json(['success' => 'Product added to wishlist !!!']);
        } else {
            return response()->json(['error' => 'Product already in wishlist !!!']);
        }
    }

    public function showWishlist()
    {
        // Lấy danh sách yêu thích từ session, đảm bảo luôn là một mảng
        $wishlist = Session::get('wishlist', []);

        // Truyền dữ liệu wishlist vào view
        return view('web.pages.wishlist', ['wishlist' => $wishlist]);
    }

    public function removeFromWishlist(Request $request)
    {
        $productId = $request->input('product_id');

        // Lấy danh sách yêu thích từ session
        $wishlist = Session::get('wishlist', []);

        // Kiểm tra nếu sản phẩm tồn tại trong danh sách
        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]); // Xóa sản phẩm khỏi danh sách
            Session::put('wishlist', $wishlist); // Cập nhật lại session

            return response()->json(['success' => 'Product removed from wishlist !!!']);
        } else {
            return response()->json(['error' => 'Product not found in wishlist !!!'], 404);
        }
    }
}
