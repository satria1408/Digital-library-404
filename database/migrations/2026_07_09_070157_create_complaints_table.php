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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique(); // Format unik pelacakan (misal: PGD-2026-0001)
            
            // Mencatat ID siswa yang melapor secara internal di database
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->enum('type', ['kerusakan', 'keluhan']);
            $table->string('category');
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->boolean('is_anonymous')->default(true); 
            $table->enum('status', ['diterima', 'diproses', 'selesai'])->default('diterima');
            $table->text('admin_notes')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};