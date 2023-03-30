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
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('description', 9000)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->float('price', 10, 2);
            $table->float('compare_at_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->float('weight', 10, 3)->nullable();
            $table->string('vendor', 255)->nullable();
            $table->boolean('has_variants')->default(0);
            $table->boolean('visibility')->nullable();
            $table->timestamps();
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
