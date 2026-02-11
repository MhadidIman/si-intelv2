<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ormas extends Model
{
    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'nama_pimpinan', // <--- HARUS ADA INI
        'alamat_sekretariat',
        'bentuk_organisasi',
        'status_legalitas',
        'nomor_sk',
        'kegiatan_utama',
        'jumlah_anggota',
        'afiliasi',
        'status_pengawasan',
        'foto_lambang'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
