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
        Schema::create('complaint_logs', function (Blueprint $table) {
            $table->id();
            // Menghubungkan log ke tabel pengaduan utama
            $table->foreignId('complaint_id')->constrained('complaints')->onDelete('cascade');
            
            // Blackbox akuntabilitas: Mencatat admin/guru mana yang melakukan update status
            $table->foreignId('changed_by_admin_id')->constrained('users')->onDelete('cascade');
            
            $table->string('status_from'); // Status awal sebelum diubah
            $table->string('status_to');   // Status baru setelah dieksekusi
            $table->text('notes')->nullable(); // Alasan internal perbaikan atau catatan sistem
            
            $table->timestamps(); // created_at otomatis mencatat waktu persis eksekusi admin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_logs');
    }
};