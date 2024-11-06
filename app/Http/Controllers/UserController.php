<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;



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
        $user = User::create([
            'Name' => $request->first_name . ' ' . $request->last_name,
            'Email' => $request->email,
            'Password' => Hash::make($request->password),
            'Role' => 'customer',
        ]);

        // Đăng nhập người dùng ngay sau khi đăng ký
        Auth::login($user);

        return redirect()->route('user.account')->with('success', 'Registration successful. Welcome!'); // Chuyển hướng đến trang tài khoản
    }

    public function login(Request $request)
    {

        Log::info($request->all());

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('Email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->Password)) {
            Auth::login($user);

            if ($user->Role === 'admin') {
                return redirect()->route('admin.pages.admin-index'); // Trang admin
            } else {
                return redirect()->route('web.pages.index'); // Trang customer
            }
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }
    }

    public function redirectToGoogle(string $provider)
    {
        return Socialite::driver($provider)
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // Tìm hoặc tạo người dùng trong cơ sở dữ liệu
        $authUser = User::where('Email', $user->getEmail())->first();

        if ($authUser) {
            // Đăng nhập người dùng đã tồn tại
            Auth::login($authUser, true);
        } else {
            // Tạo người dùng mới
            $authUser = User::create([
                'Name' => $user->getName(),
                'Email' => $user->getEmail(),
                'Password' => Hash::make(uniqid()), // Tạo mật khẩu ngẫu nhiên
                'Role' => 'customer',
            ]);
            Auth::login($authUser, true);
        }

        return redirect()->route('web.pages.index'); // Chuyển hướng đến trang chính
    }

    public function showAccount()
    {
        //dd($user = Auth::user());
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập

        return view('web.pages.account', compact('user')); // Trả về view với thông tin người dùng
    }


    //Cập nhật thông tin người dùng
    public function update(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Cập nhật thông tin người dùng
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập

        // Kiểm tra xem người dùng có tồn tại không
        if ($user instanceof User) { // Kiểm tra xem $user có phải là một đối tượng User không
            $user->Name = $request->full_name;
            $user->Email = $request->email;
            $user->Phone = $request->phone;
            $user->Address = $request->address;

            // Cập nhật mật khẩu nếu có
            if ($request->filled('password')) {
                $user->Password = Hash::make($request->password);
            }

            $user->save(); // Lưu thông tin người dùng
        } else {
            // Xử lý trường hợp người dùng không tồn tại
            return redirect()->back()->withErrors(['user' => 'Người dùng không tồn tại.']);
        }

        // Set a success message
        return redirect()->route('web.pages.index')->with('success', 'Profile updated successfully!');
    }

    public function sendPasswordResetLink(Request $request)
    {
        // Validate the incoming request to ensure the email is provided
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the user exists with the provided email
        $user = User::where('Email', $request->email)->first();

        // If the user does not exist, return an error message
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }

        // Prepare the data to send to the email view
        $data = [
            'name' => $user->Name, // User's name
            'email' => $request->email // Include the email in the data array
        ];

        // Send the email using the 'emails.reset_password' view
        Mail::send('emails.reset_password', $data, function ($message) use ($request) {
            $message->from('temppol1901@gmail.com', 'PhiLong'); // Sender's email
            $message->to($request->email, 'Customer'); // Recipient's email
            $message->subject('Yêu cầu đặt lại mật khẩu'); // Email subject
        });

        // Redirect back with a success message
        return redirect()->route('web.pages.index')->with('success', 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('Email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }

        // Mã hóa mật khẩu mới và lưu vào cơ sở dữ liệu
        $user->Password = Hash::make($request->password);
        $user->save();

        // Gửi email để đặt lại mật khẩu
        Mail::send('emails.reset_password', ['name' => $user->Name, 'email' => $request->email], function ($message) use ($request) {
            $message->from('temppol1901@gmail.com', 'PhiLong');
            $message->to($request->email, 'Customer');
            $message->subject('Yêu cầu đặt lại mật khẩu');
        });

        // Hiển thị thông báo sau khi gửi email
        return redirect()->route('web.pages.index')->with('success', 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn!')->with('alert', 'Check your mail');
    }
    public function showResetForm($email)
    {
        return view('auth.passwords.reset')->with(['email' => $email]);
    }

    public function logout()
    {
        Auth::logout(); // Đăng xuất người dùng
        return redirect()->route('web.pages.index')->with('success', 'Bạn đã đăng xuất thành công!'); // Chuyển hướng đến trang chính
    }
}
