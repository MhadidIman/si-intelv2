<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wna extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'negara_asal',      // Harus ada
        'nomor_paspor',
        'tujuan_kunjungan',
        'sponsor',
        'tempat_tinggal',   // Harus ada
        'masa_berlaku_izin',
        'status_verifikasi',
        'foto'
    ];

    protected $casts = [
        'tanggal_tiba' => 'date',
        'masa_berlaku_izin_tinggal' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
