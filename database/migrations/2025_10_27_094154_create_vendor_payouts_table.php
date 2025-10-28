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
        Schema::create('vendor_payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('fee_amount')->nullable();
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->string('paystack_transfer_id')->nullable();
            $table->string('transfer_reference')->nullable();
            $table->string('status', 50)->default('Failed');
            $table->longText('paystack_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_payouts');
    }
};
