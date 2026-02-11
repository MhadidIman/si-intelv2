<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Lapinhar;
use App\Models\Dpo;
use App\Models\Ormas;
use App\Models\Wna;
use App\Models\JmsActivity;
use App\Models\PamSdo;
use Illuminate\Support\Facades\Auth;

class DashboardIndex extends Component
{
    public function render()
    {
        // Hitung data real dari database
        $totalLapinhar = Lapinhar::count();
        $totalDpo = Dpo::where('status_pencarian', 'buron')->count();
        $totalOrmas = Ormas::where('status_pengawasan', 'aktif')->count();
        $totalWna = Wna::count();

        $latestLapinhar = Lapinhar::latest()->take(5)->get();

        $pending = [
            'lapinhar' => Lapinhar::where('status_verifikasi', 'pending')->count(),
            'dpo'      => Dpo::where('status_verifikasi', 'pending')->count(),
            'wna'      => Wna::where('status_verifikasi', 'pending')->count(),
            'ormas'    => Ormas::where('status_verifikasi', 'pending')->count(),
            'jms'      => JmsActivity::where('status_verifikasi', 'pending')->count(),
            'pam'      => PamSdo::where('status_verifikasi', 'pending')->count(),
        ];

        $totalPending = array_sum($pending);

        // Pastikan path view-nya benar (dashboard.dashboard)
        return view('livewire.dashboard.dashboard', [
            'totalLapinhar' => $totalLapinhar,
            'totalDpo' => $totalDpo,
            'totalOrmas' => $totalOrmas,
            'totalWna' => $totalWna,
            'latestLapinhar' => $latestLapinhar,
            'pending' => $pending,
            'totalPending' => $totalPending
        ])->layout('layouts.app');
    }
}
