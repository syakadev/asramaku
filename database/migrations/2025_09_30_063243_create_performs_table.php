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
        Schema::create('performs', function (Blueprint $table) {
            $table->id();
            $table->string('img'); // Penilaian/skor
            $table->date('date');
            $table->enum('status', ['dilaksanakan', 'tidak dilaksanakan']);
            $table->foreignId('dutyschedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang dinilai
            $table->timestamps();        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performs');
    }
};
