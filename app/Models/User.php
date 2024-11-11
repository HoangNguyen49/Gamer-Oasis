<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; 
    protected $primaryKey = 'User_id'; 
    public $timestamps = true;
    protected $fillable = [
        'Name',
        'Phone',
        'Address',
        'Password',
        'Email',
        'Role',
    ];

    protected $hidden = [
        'Password', 
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // public function isAdmin()
    // {
    //     return $this->Role === 'admin'; // Điều chỉnh điều kiện dựa trên cách bạn quản lý vai trò người dùng
    // }
    public function getAuthPassword()
    {
        return $this->password;
    }
}
