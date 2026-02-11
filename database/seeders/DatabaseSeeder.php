<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Khusus ADMIN (Kepala Seksi)
        User::create([
            'name'     => 'Dimas Purnama Putra, S.H., M.H.',
            'email'    => 'admin@kejaksaan.go.id',
            'password' => Hash::make('adminintel123'),
            'role'     => 'admin', // Pastikan kolom role ada di tabel users
        ]);

        // 2. Akun Contoh STAFF (Staf Intelijen)
        User::create([
            'name'     => 'Staf Intelijen 1',
            'email'    => 'staff@kejaksaan.go.id',
            'password' => Hash::make('staffintel123'),
            'role'     => 'staff',
        ]);
    }
}
