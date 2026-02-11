<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// --- IMPORT KOMPONEN LIVEWIRE ---
use App\Livewire\Users\UserIndex;
use App\Livewire\Lapinhar\LapinharIndex;
use App\Livewire\Dpo\DpoIndex;
use App\Livewire\Wna\WnaIndex;
use App\Livewire\Ormas\OrmasIndex;
use App\Livewire\PamSdo\PamSdoIndex;
use App\Livewire\Lapdu\LapduIndex;
use App\Livewire\Jms\JmsIndex;
use App\Livewire\Kerawanan\KerawananIndex;

/*
|--------------------------------------------------------------------------
| Web Routes (Aplikasi SI-INTEL)
|--------------------------------------------------------------------------
*/

// Halaman Depan (Welcome)
Route::view('/', 'welcome');

// Dashboard Utama
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Halaman Profil User (Bawaan Breeze)
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// --- GRUP RUTE OPERASIONAL (Wajib Login) ---
Route::middleware(['auth'])->group(function () {

    // 1. MANAJEMEN PERSONIL
    Route::get('/users', UserIndex::class)->name('users.index');

    // 2. MODUL OPERASIONAL INTELIJEN
    Route::get('/lapinhar', LapinharIndex::class)->name('lapinhar.index');
    Route::get('/dpo', DpoIndex::class)->name('dpo.index');
    Route::get('/wna', WnaIndex::class)->name('wna.index');
    Route::get('/ormas', OrmasIndex::class)->name('ormas.index');
    Route::get('/pam-sdo', PamSdoIndex::class)->name('pam-sdo.index');

    // 3. MODUL PELAYANAN & GIAT
    Route::get('/lapdu', LapduIndex::class)->name('lapdu.index');
    Route::get('/jms', JmsIndex::class)->name('jms.index');
    Route::get('/kerawanan', KerawananIndex::class)->name('kerawanan.index');

    // 4. RUTE CETAK LAPORAN (PDF)
    Route::controller(ReportController::class)
        ->prefix('reports')            // URL diawali dengan /reports/...
        ->name('reports.')             // Nama route diawali dengan reports....
        ->group(function () {

            // Cetak Lapinhar
            Route::get('/lapinhar', 'cetakLapinhar')->name('lapinhar');
            Route::get('/lapinhar/{id}', 'cetakLapinharSatuan')->name('lapinhar.satuan');

            // Cetak DPO
            Route::get('/dpo', 'cetakDpo')->name('dpo');
            Route::get('/dpo/{id}', 'cetakDpoSatuan')->name('dpo.satuan');

            // Cetak WNA
            Route::get('/wna', 'cetakWna')->name('wna');
            Route::get('/wna/{id}', 'cetakWnaSatuan')->name('wna.satuan');

            // Cetak Ormas
            Route::get('/ormas', 'cetakOrmas')->name('ormas');
            Route::get('/ormas/{id}', 'cetakOrmasSatuan')->name('ormas.satuan');

            // Cetak PAM SDO
            Route::get('/pam-sdo', 'cetakPamSdo')->name('pam-sdo');
            Route::get('/pam-sdo/{id}', 'cetakPamSdoSatuan')->name('pam-sdo.satuan');

            // Cetak JMS
            Route::get('/jms', 'cetakJms')->name('jms');
            Route::get('/jms/{id}', 'cetakJmsSatuan')->name('jms.satuan');

            // Cetak Peta Kerawanan
            Route::get('/kerawanan', 'cetakKerawanan')->name('kerawanan');
            Route::get('/kerawanan/{id}', 'cetakKerawananSatuan')->name('kerawanan.satuan');

            // Cetak Lapdu (Pengaduan)
            Route::get('/lapdu', 'cetakLapdu')->name('lapdu');
            Route::get('/lapdu/{id}', 'cetakLapduSatuan')->name('lapdu.satuan');

            // Cetak Statistik Kinerja
            Route::get('/user-stats', 'cetakUserStats')->name('user-stats');
        });
});

require __DIR__ . '/auth.php';
