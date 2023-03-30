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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->boolean('is_default')->nullable();
            $table->string('image', 255)->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->float('compare_at_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('barcode', 10)->nullable();
            $table->float('weight', 10, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
