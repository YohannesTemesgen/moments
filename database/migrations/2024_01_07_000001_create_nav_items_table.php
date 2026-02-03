<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nav_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('icon');
            $table->string('route');
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_active')->default(true);
            $table->string('type')->default('link'); // link, button, divider
            $table->json('attributes')->nullable(); // Additional attributes like onclick, classes, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nav_items');
    }
};
