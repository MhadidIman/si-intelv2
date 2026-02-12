<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Lapinhar;
use App\Models\Wna;
use App\Models\Ormas;
// use App\Models\Dpo; // Uncomment jika model sudah ada
// use App\Models\PamSdo;
// use App\Models\Jms;

new class extends Component {
    public function with(): array
    {
        // Hitung data pending (Hanya untuk Admin yang bisa melihat notif verifikasi)
        $isAdmin = auth()->user()->role === 'admin';

        return [
            // Menu yang sudah pasti ada tabelnya
            'notif_lapinhar' => $isAdmin ? Lapinhar::where('status_verifikasi', 'pending')->count() : 0,
            'notif_wna'      => $isAdmin ? Wna::where('status_verifikasi', 'pending')->count() : 0,
            'notif_ormas'    => $isAdmin ? Ormas::where('status_verifikasi', 'pending')->count() : 0,

            // Menu lain (Placeholder / Persiapan)
            'notif_dpo'      => 0, // Ganti logicnya nanti: Dpo::where('status', 'pending')->count()
            'notif_pamsdo'   => 0,
            'notif_jms'      => 0,
        ];
    }

    public function logout(Logout $logout): void
    {
        if (class_exists(User::class) && method_exists(User::class, 'logActivity')) {
            User::logActivity('LOGOUT', 'Personil keluar dari sesi sistem terminal');
        }
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex flex-col h-full bg-[#0f172a] select-none border-r border-slate-800 relative" id="sidebar-nav">

    <div class="h-24 flex items-center px-6 shrink-0">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-4 active:scale-95 transition-all w-full">
            <div class="p-2 bg-white rounded-lg shadow-lg shadow-emerald-500/10 shrink-0">
                <img src="{{ asset('img/logo-kejaksaan.png') }}" class="h-8 w-auto" alt="Logo">
            </div>
            <div x-show="sidebarOpen" class="overflow-hidden whitespace-nowrap">
                <h1 class="text-white font-black text-lg tracking-tight leading-none italic uppercase">
                    SI-INTEL<span class="text-emerald-500 not-italic ml-0.5">V2</span>
                </h1>
                <p class="text-[9px] text-slate-500 font-bold uppercase tracking-[0.2em] mt-1">Kejari Banjarmasin</p>
            </div>
        </a>
    </div>

    <div
        x-data="{ 
            init() { this.$el.scrollTop = sessionStorage.getItem('sidebar-scroll') || 0; } 
        }"
        @scroll.debounce.100ms="sessionStorage.setItem('sidebar-scroll', $el.scrollTop)"
        class="flex-1 overflow-y-auto py-4 px-4 custom-scrollbar space-y-8">

        <div>
            <a href="{{ route('dashboard') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 group relative overflow-hidden
               {{ request()->routeIs('dashboard') 
                  ? 'bg-slate-800 text-emerald-400 border-l-2 border-emerald-500' 
                  : 'bg-slate-900/50 text-slate-400 hover:bg-slate-800 hover:text-emerald-400' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide">Beranda Utama</span>
            </a>
        </div>

        <div class="space-y-1">
            <div x-show="sidebarOpen" class="px-2 mb-2 flex items-center">
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic">Bidang Intelijen</span>
            </div>

            <a href="{{ route('lapinhar.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('lapinhar.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide flex-1">Laporan Harian</span>

                @if($notif_lapinhar > 0)
                <span x-show="sidebarOpen" class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-lg shadow-rose-500/40 animate-pulse">
                    {{ $notif_lapinhar }}
                </span>
                @endif
            </a>

            <a href="{{ route('dpo.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('dpo.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide flex-1">Daftar DPO</span>

                @if($notif_dpo > 0)
                <span x-show="sidebarOpen" class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-lg shadow-rose-500/40 animate-pulse">
                    {{ $notif_dpo }}
                </span>
                @endif
            </a>

            <a href="{{ route('wna.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('wna.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide flex-1">Data WNA</span>

                @if($notif_wna > 0)
                <span x-show="sidebarOpen" class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-lg shadow-rose-500/40 animate-pulse">
                    {{ $notif_wna }}
                </span>
                @endif
            </a>

            <a href="{{ route('ormas.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('ormas.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide flex-1">Data Ormas</span>

                @if($notif_ormas > 0)
                <span x-show="sidebarOpen" class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-lg shadow-rose-500/40 animate-pulse">
                    {{ $notif_ormas }}
                </span>
                @endif
            </a>
        </div>

        <div class="space-y-1">
            <div x-show="sidebarOpen" class="px-2 mb-2 flex items-center">
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic">Layanan & Giat</span>
            </div>

            <a href="{{ route('pam-sdo.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('pam-sdo.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide flex-1">PAM SDO</span>

                @if($notif_pamsdo > 0)
                <span x-show="sidebarOpen" class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-lg shadow-rose-500/40 animate-pulse">
                    {{ $notif_pamsdo }}
                </span>
                @endif
            </a>

            <a href="{{ route('jms.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('jms.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide flex-1">Jaksa Masuk Sekolah</span>

                @if($notif_jms > 0)
                <span x-show="sidebarOpen" class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-lg shadow-rose-500/40 animate-pulse">
                    {{ $notif_jms }}
                </span>
                @endif
            </a>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="space-y-1">
            <div x-show="sidebarOpen" class="px-2 mb-2 flex items-center">
                <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest italic">Sistem & Kontrol</span>
            </div>

            <a href="{{ route('users.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('users.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide">Manajemen Personil</span>
            </a>

            <a href="{{ route('logs.index') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('logs.*') ? 'text-white bg-slate-800' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span x-show="sidebarOpen" class="text-xs font-bold tracking-wide">Log Aktivitas</span>
            </a>
        </div>
        @endif
    </div>

    <div class="p-5 border-t border-slate-800 shrink-0 bg-[#0b0f1a]">
        @auth
        <div class="flex items-center gap-3 mb-6" x-show="sidebarOpen" x-transition>
            <div class="relative shrink-0">
                @if(auth()->user()->foto_profil)
                <img class="h-10 w-10 rounded-xl object-cover border border-slate-700 shadow-md" src="{{ asset('storage/'.auth()->user()->foto_profil) }}">
                @else
                <div class="h-10 w-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-sm border border-emerald-500 shadow-md">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                @endif
                <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-emerald-500 border-2 border-[#0b0f1a] rounded-full animate-pulse"></div>
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-black text-slate-200 truncate uppercase tracking-tight leading-tight">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-[9px] text-emerald-500 font-black uppercase tracking-[0.2em] mt-0.5">
                    {{ auth()->user()->role }}
                </p>
            </div>
        </div>
        @endauth

        <button wire:click="logout"
            class="group w-full flex items-center justify-center gap-3 p-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all duration-200 active:scale-95 border border-transparent hover:border-slate-700">
            <svg class="w-5 h-5 shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span x-show="sidebarOpen" class="text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap">Log Out Session</span>
        </button>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }
    </style>
</div>