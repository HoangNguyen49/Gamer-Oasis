<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Name' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:users',
            'Password' => 'required|string|min:8|confirmed',
            // Thêm quy tắc xác thực khác nếu cần
        ];
    }

    // Nếu bạn cần phương thức xác thực tùy chỉnh, bạn có thể định nghĩa ở đây
    // public function validateNHI($attribute, $value, $fail)
    // {
    //     // Logic xác thực tùy chỉnh
    // }
}
