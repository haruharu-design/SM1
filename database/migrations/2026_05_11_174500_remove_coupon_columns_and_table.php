<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'coupon_code')) {
                    $table->dropColumn('coupon_code');
                }

                if (Schema::hasColumn('orders', 'discount_code')) {
                    $table->dropColumn('discount_code');
                }
            });
        }

        Schema::dropIfExists('coupons');
    }

    public function down(): void
    {
        if (! Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->enum('type', ['percentage', 'fixed']);
                $table->decimal('value', 14, 2);
                $table->decimal('min_purchase', 14, 2)->nullable();
                $table->unsignedInteger('max_usage')->nullable();
                $table->unsignedInteger('used_count')->default(0);
                $table->timestamp('valid_from')->nullable();
                $table->timestamp('valid_until')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'coupon_code')) {
                    $table->string('coupon_code')->nullable()->after('tracking_number');
                }

                if (! Schema::hasColumn('orders', 'discount_code')) {
                    $table->string('discount_code')->nullable()->after('coupon_code');
                }
            });
        }
    }
};
