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
            $table->string('product_name')->nullable();
            $table->string('title')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->string('sku')->nullable();
            $table->double('old_price')->defaukt(0);
            $table->double('new_price')->defaukt(0);
            $table->integer('stock_quantity')->defaukt(0);
            $table->longText('description')->nullable();
            $table->string('unit')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->json('tags')->nullable();
            $table->string('product_owner')->nullable()->comment(('admin or vendor'));
            $table->tinyInteger('status')->default(1)->comment(('1-active,0-inactive'));;
            $table->tinyInteger('isdelete')->default(0)->comment(('1-deleted,0-not deleted'));
            $table->tinyInteger('isFeatured')->default(0);
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
