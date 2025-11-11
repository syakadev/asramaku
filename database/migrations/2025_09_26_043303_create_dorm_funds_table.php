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
        Schema::create('dorm_funds', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('note')->nullable();
            $table->enum('type', ['kas', 'denda']); //kas atau denda
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('date');
            $table->enum('status', ['pemasukan', 'pengeluaran']); // 'pemasukan', 'pengeluaran'
            $table->foreignId('infraction_id')->nullable()->constrained('infractions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dorm_funds');
    }
};
