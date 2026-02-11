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
            $table->string('nama_pimpinan'); // <-- Ini yang tadi error
            $table->text('alamat_sekretariat');

            // Detail Legalitas
            $table->string('bentuk_organisasi'); // Ormas / LSM / Yayasan
            $table->string('status_legalitas'); // Berbadan Hukum / SKT / Tidak Terdaftar
            $table->string('nomor_sk')->nullable(); // SK Kemenkumham / Kemendagri

            // Profil Kegiatan
            $table->string('kegiatan_utama'); // Sosial / Agama / Pendidikan
            $table->integer('jumlah_anggota')->nullable();
            $table->string('afiliasi')->nullable(); // Hubungan dgn parpol/org lain

            // Status Pengawasan (Penting)
            $table->string('status_pengawasan')->default('aktif'); // aktif / waspada / dibekukan

            $table->string('foto_lambang')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ormas');
    }
};
