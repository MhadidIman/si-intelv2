<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\JmsActivity;
use App\Models\PamSdo;
use App\Models\Ormas;
use App\Models\Wna;
use App\Models\Dpo;
use App\Models\Lapinhar;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    /**
     * Helper untuk menghitung data yang perlu verifikasi (Hanya untuk Admin)
     */
    public function getPendingCount($model)
    {
        if (auth()->user()->role !== 'admin') return 0;

        // Memastikan model memiliki kolom status_verifikasi sebelum query
        return $model::where('status_verifikasi', 'pending')->count();
    }
}; ?>

<div class="flex flex-col h-full bg-slate-900 text-white">
    <div class="flex items-center justify-center h-16 border-b border-slate-800 bg-slate-950">
        <h1 class="text-xl font-bold tracking-wider text-green-500">SI-INTEL</h1>
    </div>

    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto custom-scrollbar">

        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>

        @if(auth()->user()->role === 'admin')
        <div class="pt-4 pb-1 pl-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Manajemen
        </div>
        <a href="{{ route('users.index') }}" wire:navigate class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('users.*') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Data Personil
        </a>
        @endif

        <div class="pt-4 pb-1 pl-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Operasional Intel
        </div>

        @php
        // Definisi Menu Operasional agar kode lebih rapi
        $menus = [
        ['route' => 'lapinhar.index', 'name' => 'Lapinhar', 'model' => Lapinhar::class, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['route' => 'dpo.index', 'name' => 'DPO (Buronan)', 'model' => Dpo::class, 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['route' => 'wna.index', 'name' => 'Pengawasan WNA', 'model' => Wna::class, 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
        ['route' => 'ormas.index', 'name' => 'Pengawasan Ormas', 'model' => Ormas::class, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
        ['route' => 'pam-sdo.index', 'name' => 'PAM SDO', 'model' => PamSdo::class, 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        ];
        @endphp

        @foreach($menus as $menu)
        <a href="{{ route($menu['route']) }}" wire:navigate class="flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs(explode('.', $menu['route'])[0].'*') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <div class="flex items-center">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}" />
                </svg>
                {{ $menu['name'] }}
            </div>
            @php $count = $this->getPendingCount($menu['model']); @endphp
            @if($count > 0)
            <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-pulse font-bold shadow-sm">
                {{ $count }}
            </span>
            @endif
        </a>
        @endforeach

        <div class="pt-4 pb-1 pl-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Pelayanan & Giat
        </div>

        <a href="{{ route('jms.index') }}" wire:navigate class="flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('jms.*') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
            <div class="flex items-center">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                JMS
            </div>
            @php $countJms = $this->getPendingCount(JmsActivity::class); @endphp
            @if($countJms > 0)
            <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-pulse font-bold shadow-sm">
                {{ $countJms }}
            </span>
            @endif
        </a>
    </nav>

    <div class="border-t border-slate-800 p-4 bg-slate-950">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold border border-green-400 shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-green-400 font-bold uppercase tracking-widest">
                    {{ auth()->user()->role === 'admin' ? 'Kepala Seksi' : 'Staf Intelijen' }}
                </p>
            </div>
        </div>
        <button wire:click="logout" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition duration-150 focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Keluar Sistem
        </button>
    </div>
</div>