<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Kategori default untuk kebutuhan B2C
        $defaults = [
            ['Bayi', 'Produk kebutuhan bayi'],
            ['Makanan & Minuman', 'Makanan dan minuman'],
            ['Elektronik', 'Perangkat elektronik'],
            ['Kesehatan', 'Produk kesehatan'],
            ['Fashion', 'Pakaian dan aksesoris'],
            ['Lainnya', 'Kategori lainnya'],
        ];
        foreach ($defaults as [$name, $desc]) {
            \DB::table('categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $desc,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
