<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kerawanan extends Model
{
    protected $fillable = [
        'user_id',
        'status_verifikasi',
        'kecamatan',
        'bidang',
        'potensi_ancaman',
        'sumber_informasi',
        'tingkat_rawan',
        'upaya_pencegahan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
