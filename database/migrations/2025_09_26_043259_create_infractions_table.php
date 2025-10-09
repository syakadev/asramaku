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
        Schema::create('infractions', function (Blueprint $table) {
            $table->id();
             $table->string('img');
            $table->text('note')->nullable();
            $table->enum('type', ['piket', 'kerapian dan kebersihan']);
            $table->enum('status', ['dibayar', 'belum dibayar'])->default('belum dibayar');
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infractions');
    }
};
