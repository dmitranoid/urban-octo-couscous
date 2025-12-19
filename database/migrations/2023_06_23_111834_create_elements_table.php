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
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parent_id');
            $table->string('name', 250);
            $table->string('type');
            $table->string('slug', 100);
            $table->json('seo')->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->text('images')->nullable();
            $table->json('params')->nullable();
            $table->integer('position')->nullable();
            $table->boolean('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
