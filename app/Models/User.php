<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'nrp',
        'pangkat_golongan',
        'jabatan',
        'satuan_kerja',
        'no_hp',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI KE DATA INTELIJEN ---

    public function lapinhars()
    {
        return $this->hasMany(Lapinhar::class);
    }
    public function dpos()
    {
        return $this->hasMany(Dpo::class);
    }
    public function lapdus()
    {
        return $this->hasMany(Lapdu::class);
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
    public function kerawanans()
    {
        return $this->hasMany(Kerawanan::class);
    }
}
