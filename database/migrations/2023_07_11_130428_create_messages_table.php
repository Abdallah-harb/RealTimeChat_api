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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreignId('sender_id')->comment('المرسل')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->comment('المستقبل')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('read')->default(0)->nullable();
            $table->text('body')->comment('الرسائل');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
