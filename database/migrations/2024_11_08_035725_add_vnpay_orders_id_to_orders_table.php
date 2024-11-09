<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('vnpay_orders_id')->nullable(); // Thêm cột vnpay_orders_id
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('vnpay_orders_id'); // Xóa cột vnpay_orders_id nếu rollback
    });
}

};
