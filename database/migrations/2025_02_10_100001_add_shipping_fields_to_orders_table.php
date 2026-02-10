<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('distance_km', 8, 2)->nullable()->after('coupon_code');
            $table->decimal('shipping_cost', 14, 2)->default(0)->after('distance_km');
            $table->decimal('shipping_lat', 10, 8)->nullable()->after('shipping_cost');
            $table->decimal('shipping_lng', 11, 8)->nullable()->after('shipping_lat');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['distance_km', 'shipping_cost', 'shipping_lat', 'shipping_lng']);
        });
    }
};
