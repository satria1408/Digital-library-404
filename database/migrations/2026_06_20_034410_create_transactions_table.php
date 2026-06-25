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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke Siswa 
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Relasi ke Buku 
            $table->date('tanggal_pinjam'); 
            
            // TAMBAHAN BARU: Batas waktu (deadline) yang dipilih siswa dari kalender
            $table->date('tanggal_deadline'); 

            // Tetap nullable: Diisi nanti saat siswa menekan tombol "Kembalikan"
            $table->date('tanggal_kembali')->nullable(); 
            
            // DIUBAH DI SINI: Menambahkan opsi pending dan ditolak ke dalam enum status
            $table->enum('status', ['pending', 'pinjam', 'kembali', 'ditolak'])->default('pending'); 
            
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};