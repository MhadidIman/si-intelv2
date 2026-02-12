<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB; // [PENTING] Wajib ada untuk fitur Log

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',           // Nomor Induk Pegawai
        'role',          // admin / staff
        'satuan_kerja',  // Kejaksaan Negeri Sanggau
        'pangkat',       // Jaksa Pratama, dll
        'jabatan',       // Kasubsi, Staff, dll
        'no_hp',         // Nomor WhatsApp
        'foto_profil',   // Path foto profil
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Helper untuk mengecek apakah user adalah Admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI PENCATAT LOG AKTIFITAS (AUDIT TRAIL)
    |--------------------------------------------------------------------------
    | Fungsi ini merekam jejak digital (Log Activity) ke database.
    | Dipanggil via: User::logActivity('AKSI', 'KETERANGAN');
    */
    public static function logActivity($activity, $description = null)
    {
        DB::table('activity_logs')->insert([
            'user_id'     => auth()->id(),
            'activity'    => $activity,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATABASE (MODULE OPERASIONAL & GIAT)
    |--------------------------------------------------------------------------
    */

    public function lapinhars()
    {
        return $this->hasMany(Lapinhar::class);
    }

    public function dpos()
    {
        return $this->hasMany(Dpo::class);
    }

    public function wnas()
    {
        return $this->hasMany(Wna::class);
    }

    public function ormas()
    {
        return $this->hasMany(Ormas::class);
    }

    public function pamSdos()
    {
        return $this->hasMany(PamSdo::class);
    }

    public function jmsActivities()
    {
        return $this->hasMany(JmsActivity::class);
    }
}
