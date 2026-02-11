<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lapdu extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_surat',
        'tanggal_terima',
        'status_verifikasi',
        'nama_pelapor',
        'nik',
        'no_hp_pelapor',
        'nama_terlapor',
        'kategori_laporan',
        'uraian_pengaduan',
        'bukti_dukung',
        'status_laporan',
        'keterangan_tindak_lanjut',
    ];

    protected $casts = [
        'tanggal_terima' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
