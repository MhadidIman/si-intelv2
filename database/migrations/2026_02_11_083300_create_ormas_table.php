<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ormas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identitas Organisasi
            $table->string('nama_organisasi');
            $table->string('nama_pimpinan');
            $table->text('alamat_sekretariat');

            // Detail Legalitas
            $table->string('bentuk_organisasi');
            $table->string('status_legalitas');
            $table->string('nomor_sk')->nullable();

            // Profil Kegiatan
            $table->string('kegiatan_utama');
            $table->integer('jumlah_anggota')->nullable();
            $table->string('afiliasi')->nullable();

            // Status
            $table->string('status_pengawasan')->default('aktif');

            // === KOLOM WAJIB UNTUK SISTEM VERIFIKASI ===
            $table->string('status_verifikasi')->default('pending');

            $table->string('foto_lambang')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ormas');
    }
};
