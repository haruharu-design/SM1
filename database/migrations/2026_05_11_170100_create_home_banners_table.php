<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('gradient_from', 50)->default('from-red-500');
            $table->string('gradient_to', 50)->default('to-red-400');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        DB::table('home_banners')->insert([
            [
                'title' => 'Promo Spesial Hari Ini',
                'subtitle' => 'Diskon menarik untuk produk pilihan',
                'gradient_from' => 'from-red-500',
                'gradient_to' => 'to-red-400',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Koleksi Terbaru',
                'subtitle' => 'Produk terbaru dengan kualitas terbaik',
                'gradient_from' => 'from-blue-500',
                'gradient_to' => 'to-blue-400',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Belanja Lebih Mudah',
                'subtitle' => 'Pengalaman belanja nyaman dan aman',
                'gradient_from' => 'from-purple-500',
                'gradient_to' => 'to-pink-500',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_banners');
    }
};
