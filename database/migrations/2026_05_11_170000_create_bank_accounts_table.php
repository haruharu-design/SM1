<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->string('account_number', 100);
            $table->string('account_name');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $defaults = [
            ['code' => 'bca', 'name' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'Toko Sinar Mentari', 'is_active' => true, 'sort_order' => 1],
            ['code' => 'bni', 'name' => 'BNI', 'account_number' => '0987654321', 'account_name' => 'Toko Sinar Mentari', 'is_active' => true, 'sort_order' => 2],
            ['code' => 'mandiri', 'name' => 'Mandiri', 'account_number' => '1122334455', 'account_name' => 'Toko Sinar Mentari', 'is_active' => true, 'sort_order' => 3],
        ];

        $now = now();
        foreach ($defaults as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        DB::table('bank_accounts')->insert($defaults);
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
