<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Thêm các cột cần thiết
            $table->string('full_name')->nullable(); // Tên khách hàng
            $table->string('phone')->nullable(); // Số điện thoại
            $table->string('address')->nullable(); // Địa chỉ
            $table->string('email_address')->nullable(); // Email
            $table->timestamp('updated_at')->nullable(); // Cột updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Chỉ xoá những cột tồn tại
            if (Schema::hasColumn('orders', 'full_name')) {
                $table->dropColumn('full_name');
            }
            if (Schema::hasColumn('orders', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('orders', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('orders', 'email_address')) {
                $table->dropColumn('email_address');
            }
            if (Schema::hasColumn('orders', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};
