<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add unique index on cars.vin if it doesn't exist
        if (empty(\Illuminate\Support\Facades\DB::select("SHOW INDEX FROM `cars` WHERE Key_name = 'cars_vin_unique'"))) {
            Schema::table('cars', function (Blueprint $table) {
                $table->unique('vin');
            });
        }

        // Add unique index on sales_orders.order_number if not exists
        if (empty(\Illuminate\Support\Facades\DB::select("SHOW INDEX FROM `sales_orders` WHERE Key_name = 'sales_orders_order_number_unique'"))) {
            Schema::table('sales_orders', function (Blueprint $table) {
                $table->unique('order_number');
            });
        }
    }

    public function down()
    {
        // Drop indexes only if they exist
        if (!empty(\Illuminate\Support\Facades\DB::select("SHOW INDEX FROM `cars` WHERE Key_name = 'cars_vin_unique'"))) {
            Schema::table('cars', function (Blueprint $table) {
                $table->dropUnique(['vin']);
            });
        }

        if (!empty(\Illuminate\Support\Facades\DB::select("SHOW INDEX FROM `sales_orders` WHERE Key_name = 'sales_orders_order_number_unique'"))) {
            Schema::table('sales_orders', function (Blueprint $table) {
                $table->dropUnique(['order_number']);
            });
        }
    }
};
