<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $brandId = $request->input('brand_id');
        $wishlist = Session::get('wishlist', []);

        // Kiểm tra nếu brand_id chưa tồn tại trong wishlist
        if (!in_array($brandId, $wishlist)) {
            $wishlist[] = $brandId; // Thêm brand_id vào wishlist
            Session::put('wishlist', $wishlist);
            return response()->json(['success' => 'Brand added to wishlist.']);
        } else {
            return response()->json(['error' => 'Brand already in wishlist.'], 400);
        }
    }

    public function showWishlist()
    {
        $wishlist = Session::get('wishlist', []);
        return view('web.pages.wishlist', compact('wishlist'));
    }
}
