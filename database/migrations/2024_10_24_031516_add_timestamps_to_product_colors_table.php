<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToProductColorsTable extends Migration
{
    public function up()
    {
        Schema::table('Product_Colors', function (Blueprint $table) {
            $table->timestamps(); // Thêm cột created_at và updated_at
        });
    }

    public function down()
    {
        Schema::table('Product_Colors', function (Blueprint $table) {
            $table->dropTimestamps(); // Xóa cột created_at và updated_at
        });
    }
}
