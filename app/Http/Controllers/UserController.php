<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng từ bảng users
        $users = User::all();


        return view('admin.pages.quanlikhachhang', compact('users'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:50|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        User::create([
            'Name' => $request->first_name . ' ' . $request->last_name,
            'Email' => $request->email,
            'Password' => md5($request->password),
            'Role' => 'customer',
        ]);

        return redirect()->route('web.pages.index')->with('success', 'Registration successful. Please log in.');
    }

    public function login(Request $request)
    {

        Log::info($request->all());

        $user = User::where([
            'Email' => $request->email,
            'Password' => md5($request->password),
        ])->first();
        //dd($user);
        if($user)
        {
            if ($user->Role === 'admin') {
                return redirect()->route('admin.pages.admin-index'); // Trang admin
            } else {
                return redirect()->route('web.pages.index'); // Trang customer
            }
        
        }
          
        else
        { 
            return redirect()->back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);}
    }
}
