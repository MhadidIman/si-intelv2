<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapinhars', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Petugas yg input)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Data Utama
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('sumber_informasi');
            $table->string('bidang'); // Ipoleksosbudhankam
            $table->text('peristiwa');
            $table->text('pendapat'); // Analisa Intelijen

            // Status
            $table->enum('status', ['rahasia', 'biasa'])->default('rahasia');
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapinhars');
    }
};
