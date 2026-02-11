<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN (Kepala Seksi) - Login pakai NIP
        User::create([
            'name'     => 'DIMAS PURNAMA PUTRA, S.H., M.H.',
            'nip'      => '199001012015011001', // 18 Digit
            'email'    => 'admin@kejaksaan.go.id',
            'password' => Hash::make('adminintel123'),
            'role'     => 'admin',
            'jabatan'  => 'Kepala Seksi Intelijen',
        ]);

        // 2. Akun STAFF (Staf Intelijen) - Login pakai NIP
        User::create([
            'name'     => 'STAFF INTELIJEN 01',
            'nip'      => '199001012015011002', // 18 Digit
            'email'    => 'staff@kejaksaan.go.id',
            'password' => Hash::make('staffintel123'),
            'role'     => 'staff',
            'jabatan'  => 'Staf Operasional',
        ]);
    }
}
