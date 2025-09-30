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
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama barang
            $table->text('description')->nullable();
            $table->date('date_found');
            $table->date('date_taken')->nullable();
            $table->string('img')->nullable(); // Path gambar
            $table->string('status'); // Misal: 'tersedia', 'diambil'
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // User yang mengambil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
