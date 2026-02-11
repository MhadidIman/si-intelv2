<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerawanans', function (Blueprint $table) {
            $table->id();

            // Relasi ke User
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Status Verifikasi
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');

            // Data Kerawanan
            $table->string('kecamatan'); // Lokasi
            $table->string('bidang'); // Ipoleksosbudhankam
            $table->text('potensi_ancaman');
            $table->string('sumber_informasi')->nullable();

            // Indikator Level
            $table->enum('tingkat_rawan', ['tinggi', 'sedang', 'rendah'])->default('rendah');

            $table->text('upaya_pencegahan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerawanans');
    }
};
