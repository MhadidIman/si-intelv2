<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lapinhar extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_surat',
        'tanggal_surat',
        'sumber_informasi',
        'bidang',
        'peristiwa',
        'pendapat',
        'status',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
