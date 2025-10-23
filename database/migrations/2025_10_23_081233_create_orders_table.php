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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->string('transaction_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_amount')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->tinyInteger('shipping_id')->default(1)->nullable();
            $table->string('shipping_amount')->default(0)->nullable();
            $table->string('total_amount')->default(0)->nullable();
            $table->string('payment_method')->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comment('0 => Canceled, 1 => Processing, 2 => In progress, 3 => Completed');
            $table->tinyInteger('is_payment')->default(0)->nullable()->comment('0 => false, 1 => true');
            $table->json('payment_data')->nullable();
            $table->tinyInteger('is_delete')->default(0)->nullable()->comment('0 => false, 1 => true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
