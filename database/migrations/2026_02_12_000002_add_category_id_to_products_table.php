<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('image')->constrained()->restrictOnDelete();
        });

        // Migrasi data category text ke category_id
        $categories = DB::table('categories')->pluck('id', 'name');
        $lainnyaId = $categories->get('Lainnya') ?? $categories->first();
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $categoryId = $lainnyaId;
            if (!empty($product->category)) {
                $categoryId = $categories->get($product->category) ?? $lainnyaId;
            }
            DB::table('products')->where('id', $product->id)->update(['category_id' => $categoryId]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('image');
        });
    }
};
