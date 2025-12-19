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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sku', 20)->nullable();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('slug', 100)->nullable();
            $table->string('image', 255)->nullable();
            $table->json('images')->nullable();
            $table->json('options')->nullable();
            $table->json('files')->nullable();
            $table->foreignIdFor(\App\Models\Manufacturer::class)->nullable();
            $table->foreignId('category_id')->nullable();
            $table->integer('position')->default(100);
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
