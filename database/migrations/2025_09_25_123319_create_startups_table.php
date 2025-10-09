<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('industry_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('logo_path', 2048)->nullable();
            $table->string('banner_path', 2048)->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('stage')->nullable();
            $table->boolean('personal_startup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
