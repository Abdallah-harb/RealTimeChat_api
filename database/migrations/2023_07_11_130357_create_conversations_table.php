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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->comment('المرسل')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->comment('المستقبل')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('last_time_message')->comment('اخر ظهور')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
