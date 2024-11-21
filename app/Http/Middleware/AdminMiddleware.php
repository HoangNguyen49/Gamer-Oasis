<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('AdminMiddleware is being called');

        // Kiểm tra xem người dùng đã đăng nhập và có vai trò 'admin' hay không
        if (Auth::check() && Auth::user()->Role === 'admin') {
            return $next($request);
        }

        // Thêm điều kiện kiểm tra cho người dùng có vai trò 'customer'
        if (Auth::check() && Auth::user()->Role === 'customer') {
            abort(404); // Trả về lỗi 404 cho người dùng có vai trò 'customer'
        }

        // Thêm điều kiện kiểm tra cho các trang backend
        if ($request->is('/admin')) { // Kiểm tra nếu URL bắt đầu bằng 'admin/'
            // Trả về lỗi 404 cho người dùng không phải admin
            abort(404);
        }

        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        return redirect()->route('login')->withErrors(['access' => 'You need to log in first.']);
    }
}
