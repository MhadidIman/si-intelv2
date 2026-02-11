<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JmsActivity extends Model
{
    protected $fillable = [
        'user_id',
        'nama_sekolah',
        'tanggal_kegiatan',
        'materi',
        'jumlah_peserta',
        'narasumber',
        'keterangan',
        'foto_kegiatan',
        'status_verifikasi'
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
