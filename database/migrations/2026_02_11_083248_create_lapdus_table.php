<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapdus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');

            // Data Pelapor & Terlapor
            $table->string('nama_pelapor');
            $table->string('nik')->nullable();
            $table->string('no_hp_pelapor')->nullable();
            $table->string('nama_terlapor')->nullable();

            // Detail Aduan
            $table->string('kategori_laporan'); // Korupsi / Umum
            $table->text('uraian_pengaduan');
            $table->string('bukti_dukung')->nullable();

            // Tindak Lanjut
            $table->enum('status_laporan', ['menunggu', 'proses', 'selesai'])->default('menunggu');
            $table->text('keterangan_tindak_lanjut')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapdus');
    }
};
