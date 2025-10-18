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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // Can belong to either a user or a vendor
            $table->unsignedBigInteger('user_id')->nullable();
            // Type of receiver (user, vendor, or admin)
            $table->enum('user_type', ['user', 'vendor', 'admin'])->nullable()
                ->comment('Identifies whether notification is for user, vendor, or admin');
            // Notification details
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->mediumText('message')->nullable();
            // Flags
            $table->boolean('is_admin')->default(false)->comment('1 => sent to admin, 0 => not admin');
            $table->boolean('is_read')->default(false)->comment('1 => read, 0 => unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
