<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->index('order_number');
            $table->index('status');
            $table->index('created_at');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->index('vin');
            $table->index('brand');
            $table->index('model');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('full_name');
            $table->index('phone');
        });
    }

    public function down()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropIndex(['order_number']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['vin']);
            $table->dropIndex(['brand']);
            $table->dropIndex(['model']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['full_name']);
            $table->dropIndex(['phone']);
        });
    }
};
