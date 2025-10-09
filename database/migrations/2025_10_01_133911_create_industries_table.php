<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('industries')->insert([
            ['name' => 'Technology'],
            ['name' => 'Healthcare'],
            ['name' => 'Finance'],
            ['name' => 'Education'],
            ['name' => 'E-commerce'],
            ['name' => 'Entertainment'],
            ['name' => 'Travel & Tourism'],
            ['name' => 'Agriculture'],
            ['name' => 'Energy'],
            ['name' => 'Telecommunications'],
            ['name' => 'Consulting'],
            ['name' => 'Non-Profit'],
            ['name' => 'Biotechnology'],
            ['name' => 'Pharmaceuticals'],
            ['name' => 'Fashion'],
            ['name' => 'Sports & Fitness'],
            ['name' => 'Logistics & Supply Chain'],
            ['name' => 'Marketing & Advertising'],
            ['name' => 'Food Delivery'],
            ['name' => 'Transportation'],
            ['name' => 'Food & Beverage'],
            ['name' => 'Manufacturing'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
