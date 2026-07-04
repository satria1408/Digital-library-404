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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            // Hubungkan ke tabel users, nullable karena diakses anonim dari halaman login
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            
            // Kolom baru untuk sistem surat-suratan (ticket tracking)
            $table->string('ticket_code', 20)->unique(); 
            $table->string('subjek', 150);
            $table->text('isi_saran');
            $table->text('reply_developer')->nullable(); // Menampung balasan pesan dari developer
            
            // Tambah status 'replied' untuk menandai surat yang sudah lo balas
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};