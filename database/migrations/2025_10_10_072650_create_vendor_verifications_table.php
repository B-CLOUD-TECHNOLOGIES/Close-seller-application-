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
        Schema::create('vendor_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('question')->nullable();
            $table->text('cac')->nullable();
            $table->text('nin')->nullable();
            $table->text('video_url')->nullable();
            $table->text('web_url')->nullable();
            $table->text('address')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=approved, 2=rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_verifications');
    }
};
