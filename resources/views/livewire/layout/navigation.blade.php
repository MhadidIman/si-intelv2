<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Memproses keluar dari sistem dan kembali ke halaman utama.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex flex-col h-full bg-[#111827] select-none border-r border-slate-800" id="sidebar-nav">
    <div class="h-20 flex items-center px-6 bg-[#0b0f1a] border-b border-slate-800 shrink-0">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 active:scale-95 transition-all">
            <div class="p-1.5 bg-white rounded shadow-sm shrink-0">
                <img src="{{ asset('img/logo-kejaksaan.png') }}" class="h-8 w-auto" alt="Logo">
            </div>
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" class="overflow-hidden whitespace-nowrap">
                <h1 class="text-slate-100 font-bold text-lg tracking-tight leading-none uppercase">
                    SI-INTEL<span class="text-emerald-500 ml-0.5">V2</span>
                </h1>
                <p class="text-[9px] text-slate-500 font-medium uppercase tracking-[0.2em] mt-1">Command Center</p>
            </div>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 custom-scrollbar space-y-8">

        <div class="px-2">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" label="Beranda Utama">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>
        </div>

        <div class="space-y-1 px-2">
            <div x-show="sidebarOpen" class="px-4 mb-2 flex items-center">
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Bidang Intelijen</span>
            </div>

            <x-sidebar-link :href="route('lapinhar.index')" :active="request()->routeIs('lapinhar.*')" label="Laporan Harian">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>

            <x-sidebar-link :href="route('dpo.index')" :active="request()->routeIs('dpo.*')" label="Daftar DPO">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>

            <x-sidebar-link :href="route('wna.index')" :active="request()->routeIs('wna.*')" label="Data WNA">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                    </svg>
                </x-slot>
            </x-sidebar-link>

            <x-sidebar-link :href="route('ormas.index')" :active="request()->routeIs('ormas.*')" label="Data Ormas">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>

            <x-sidebar-link :href="route('pam-sdo.index')" :active="request()->routeIs('pam-sdo.*')" label="PAM SDO">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>
        </div>

        <div class="space-y-1 px-2 border-t border-slate-800/50 pt-6">
            <div x-show="sidebarOpen" class="px-4 mb-2 flex items-center">
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Layanan & Giat</span>
            </div>

            <x-sidebar-link :href="route('jms.index')" :active="request()->routeIs('jms.*')" label="Jaksa Masuk Sekolah">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>
        </div>
        @if(auth()->user()->role === 'admin')
        <div class="space-y-1 px-2 border-t border-slate-800/50 pt-6">
            <div x-show="sidebarOpen" class="px-4 mb-2 flex items-center">
                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Sistem & Kontrol</span>
            </div>

            <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')" label="Manajemen Personil">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </x-slot>
            </x-sidebar-link>
        </div>
        @endif
    </div>

    <div class="p-4 bg-[#0b0f1a] border-t border-slate-800 shrink-0">
        @auth
        <div class="flex items-center mb-5 px-2 overflow-hidden" x-show="sidebarOpen" x-transition>
            <div class="relative shrink-0">
                <img class="h-10 w-10 rounded-xl object-cover border border-slate-700 shadow-lg"
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=10b981&background=064e3b&bold=true" alt="Avatar">
                <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-emerald-500 border-2 border-[#0b0f1a] rounded-full animate-pulse"></div>
            </div>
            <div class="ms-3 overflow-hidden">
                <p class="text-xs font-bold text-slate-200 truncate uppercase tracking-tight">{{ auth()->user()->name }}</p>
                <p class="text-[9px] text-emerald-500 font-black uppercase tracking-[0.2em] mt-0.5">{{ auth()->user()->role }}</p>
            </div>
        </div>
        @endauth

        <button wire:click="logout"
            class="group w-full flex items-center justify-center p-3 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all duration-500 active:scale-95 border border-transparent hover:border-rose-500/20 shadow-sm">
            <svg class="w-5 h-5 shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span x-show="sidebarOpen" class="ms-3 text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap transition-all duration-300">Log Out Session</span>
        </button>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }
    </style>
</div>