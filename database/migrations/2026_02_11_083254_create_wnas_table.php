<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wnas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identitas WNA
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('negara_asal');
            $table->string('nomor_paspor');

            // Detail Kunjungan
            $table->string('tujuan_kunjungan');
            $table->string('sponsor')->nullable();
            $table->text('tempat_tinggal');
            $table->date('masa_berlaku_izin');

            // === KOLOM WAJIB UNTUK SISTEM VERIFIKASI ===
            $table->string('status_verifikasi')->default('pending');

            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wnas');
    }
};
