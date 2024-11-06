<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có quyền admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng về trang khác
        return redirect('/'); // Hoặc trang khác
    }
}
