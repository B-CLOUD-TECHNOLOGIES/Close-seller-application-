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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('cart_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('price')->default(0)->nullable();
            $table->string('quantity')->default(0)->nullable();
            $table->string('color_name')->nullable();
            $table->string('size_name')->nullable();
            $table->string('size_amount')->nullable();
            $table->string('total_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
