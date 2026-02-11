<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan isi Schema::create seperti ini:
        Schema::create('pam_sdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->string('kategori_pam');
            $table->date('tanggal_kegiatan');
            $table->string('lokasi');
            $table->string('pelaksana');
            $table->text('keterangan')->nullable();
            $table->string('status');

            // TAMBAHKAN BARIS INI:
            $table->string('status_verifikasi')->default('pending');

            $table->string('foto_dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pam_sdos');
    }
};
