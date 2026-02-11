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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // === Identitas Dasar ===
            $table->string('name'); // Nama Lengkap beserta Gelar
            $table->string('email')->unique();

            // === SISTEM ROLE (PENTING) ===
            // Default diset 'staff', admin diset manual lewat seeder atau manajemen user
            $table->enum('role', ['admin', 'staff'])->default('staff');

            // === Identitas Pegawai Kejaksaan ===
            $table->string('nip', 18)->nullable()->unique(); // NIP 18 Digit
            $table->string('nrp', 12)->nullable()->unique(); // NRP (Khusus Jaksa)
            $table->string('pangkat_golongan')->nullable(); // Contoh: Jaksa Madya (IV/a)
            $table->string('jabatan')->nullable();          // Contoh: Kasi Intel, Staff Tata Usaha
            $table->string('satuan_kerja')->nullable();     // Contoh: Kejaksaan Negeri Banjarmasin
            $table->string('no_hp')->nullable();
            $table->string('foto_profil')->nullable();

            // === Sistem Keamanan Laravel ===
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
