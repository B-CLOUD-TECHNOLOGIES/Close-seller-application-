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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('category_name')->nullable();
            $table->text('image')->nullable();
            $table->tinyInteger('inMenu')->default(0);
            $table->tinyInteger('status')->default(1)->comment(('1-active,0-inactive'));
            $table->tinyInteger('isdelete')->default(0)->comment(('1-deleted,0-not deleted'));;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
