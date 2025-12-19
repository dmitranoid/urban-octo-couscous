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
        Schema::table('products',  function (Blueprint $table) {
            $table->decimal('stock')->nullable();
            $table->decimal( 'partner_stock')->nullable();
            $table->decimal( 'price')->nullable();
            $table->string( 'meta_title', 100)->nullable();
            $table->string('meta_description', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products',  function (Blueprint $table) {

            $table->dropColumn('stock');
            $table->dropColumn('partner_stock');
            $table->dropColumn('price');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

    }
};
