<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek file database/migrations/xxxx_create_jms_activities_table.php
        Schema::create('jms_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_sekolah');
            $table->date('tanggal_kegiatan');
            $table->string('materi');
            $table->integer('jumlah_peserta');
            $table->string('narasumber');

            // PASTIKAN DUA BARIS INI ADA:
            $table->text('keterangan')->nullable();
            $table->string('status_verifikasi')->default('pending');

            $table->string('foto_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jms_activities');
    }
};
