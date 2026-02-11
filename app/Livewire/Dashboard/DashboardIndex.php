<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Lapinhar;
use App\Models\Dpo;
use App\Models\Ormas;
use App\Models\Wna;
use App\Models\JmsActivity;
use App\Models\PamSdo;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Dashboard extends Component  // <--- Pastikan extends Component
{
    public function render()
    {
        // ... (codingan logic statistik yang tadi) ...

        // 1. Statistik
        $totalLapinhar = Lapinhar::count();
        $totalDpo = Dpo::where('status_pencarian', 'buron')->count();
        $totalOrmas = Ormas::where('status_pengawasan', 'aktif')->count();
        $totalWna = Wna::count();

        // 2. Tabel Terbaru
        $latestLapinhar = Lapinhar::latest()->take(5)->get();

        // 3. Pending
        $pending = [
            'lapinhar' => Lapinhar::where('status_verifikasi', 'pending')->count(),
            'dpo'      => Dpo::where('status_verifikasi', 'pending')->count(),
            'wna'      => Wna::where('status_verifikasi', 'pending')->count(),
            'ormas'    => Ormas::where('status_verifikasi', 'pending')->count(),
            'jms'      => JmsActivity::where('status_verifikasi', 'pending')->count(),
            'pam'      => PamSdo::where('status_verifikasi', 'pending')->count(),
        ];
        $totalPending = array_sum($pending);

        return view('livewire.dashboard', compact(
            'totalLapinhar',
            'totalDpo',
            'totalOrmas',
            'totalWna',
            'latestLapinhar',
            'pending',
            'totalPending'
        ));
    }
}
