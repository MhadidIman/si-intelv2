<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// --- IMPORT KOMPONEN LIVEWIRE ---
use App\Livewire\Dashboard\DashboardIndex;
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
| Web Routes - SI-INTEL V2 (Intelligence Operations System)
|--------------------------------------------------------------------------
*/

// Halaman Depan (Public)
Route::view('/', 'welcome')->name('welcome');

// --- AREA TERAUTENTIKASI ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD & PROFIL
    Route::get('dashboard', DashboardIndex::class)->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    // 2. MODUL OPERASIONAL INTELIJEN
    Route::get('/lapinhar', LapinharIndex::class)->name('lapinhar.index');
    Route::get('/dpo', DpoIndex::class)->name('dpo.index');
    Route::get('/wna', WnaIndex::class)->name('wna.index');
    Route::get('/ormas', OrmasIndex::class)->name('ormas.index');
    Route::get('/pam-sdo', PamSdoIndex::class)->name('pam-sdo.index');

    // 3. MODUL PELAYANAN & GIAT (BINMATKUM)
    Route::get('/lapdu', LapduIndex::class)->name('lapdu.index');
    Route::get('/jms', JmsIndex::class)->name('jms.index');
    Route::get('/kerawanan', KerawananIndex::class)->name('kerawanan.index');

    // 4. KHUSUS ADMINISTRATOR (SISTEM)
    // Jika Abang sudah punya middleware role, pasang di sini.
    // Sementara saya biarkan terbuka, tapi sebaiknya dikunci.
    Route::get('/users', UserIndex::class)->name('users.index');

    // 5. RUTE CETAK LAPORAN (PDF ENGINE)
    Route::controller(ReportController::class)
        ->prefix('reports')
        ->name('reports.')
        ->group(function () {
            // Bulk Reports (Rekap)
            Route::get('/lapinhar', 'cetakLapinhar')->name('lapinhar');
            Route::get('/dpo', 'cetakDpo')->name('dpo');
            Route::get('/wna', 'cetakWna')->name('wna');
            Route::get('/ormas', 'cetakOrmas')->name('ormas');
            Route::get('/pam-sdo', 'cetakPamSdo')->name('pam-sdo');
            Route::get('/jms', 'cetakJms')->name('jms');
            Route::get('/kerawanan', 'cetakKerawanan')->name('kerawanan');
            Route::get('/lapdu', 'cetakLapdu')->name('lapdu');

            // Single Item Reports (Satuan)
            Route::get('/lapinhar/{id}', 'cetakLapinharSatuan')->name('lapinhar.satuan');
            Route::get('/dpo/{id}', 'cetakDpoSatuan')->name('dpo.satuan');
            Route::get('/wna/{id}', 'cetakWnaSatuan')->name('wna.satuan');
            Route::get('/ormas/{id}', 'cetakOrmasSatuan')->name('ormas.satuan');
            Route::get('/pam-sdo/{id}', 'cetakPamSdoSatuan')->name('pam-sdo.satuan');
            Route::get('/jms/{id}', 'cetakJmsSatuan')->name('jms.satuan');
            Route::get('/kerawanan/{id}', 'cetakKerawananSatuan')->name('kerawanan.satuan');
            Route::get('/lapdu/{id}', 'cetakLapduSatuan')->name('lapdu.satuan');

            // System Logs & Stats
            Route::get('/user-stats', 'cetakUserStats')->name('user-stats');
        });
});

require __DIR__ . '/auth.php';
