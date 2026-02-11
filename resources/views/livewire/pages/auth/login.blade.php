<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component {
    public LoginForm $form;

    /**
     * Memaksa penggunaan layout guest agar halaman login 
     * tidak muncul di dalam sidebar dashboard.
     */
    public function rendering($view, $data)
    {
        $view->layout('layouts.guest');
    }

    /**
     * Menangani permintaan autentikasi masuk.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0f172a] relative overflow-hidden selection:bg-emerald-500 selection:text-white font-sans">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-emerald-900/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[50%] bg-blue-900/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-12 bg-slate-900/40 backdrop-blur-2xl border border-slate-800 shadow-[0_25px_60px_rgba(0,0,0,0.6)] sm:rounded-[2.5rem] z-10 relative">

        <div class="text-center mb-12">
            <div class="inline-block p-4 bg-white rounded-3xl shadow-[0_0_30px_rgba(255,255,255,0.05)] mb-6 transition-transform hover:scale-105 duration-500">
                <img src="{{ asset('img/logo-kejaksaan.png') }}" class="h-20 w-auto mx-auto drop-shadow-2xl" alt="Logo Kejaksaan">
            </div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">
                SI-INTEL<span class="text-emerald-500 not-italic ml-1">V2</span>
            </h1>
            <div class="flex items-center justify-center gap-3 mt-3">
                <span class="h-px w-8 bg-slate-700"></span>
                <p class="text-[10px] text-emerald-500/80 font-black uppercase tracking-[0.4em]">Secure Access Terminal</p>
                <span class="h-px w-8 bg-slate-700"></span>
            </div>
        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form wire:submit="login" class="space-y-7">
            <div class="space-y-2">
                <label for="nip" class="block text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] ml-2">Credential ID (NIP)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-emerald-500 transition-colors duration-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input wire:model="form.nip" id="nip" type="text" required autofocus
                        class="block w-full pl-12 pr-4 py-4 bg-slate-950/40 border border-slate-800 text-white rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all duration-300 placeholder-slate-700 text-sm font-bold tracking-[0.1em]"
                        placeholder="Masukkan NIP">
                </div>
                <x-input-error :messages="$errors->get('form.nip')" class="mt-2 text-xs font-bold uppercase tracking-tight" />
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] ml-2">System Access Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-emerald-500 transition-colors duration-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input wire:model="form.password" id="password" type="password" required
                        class="block w-full pl-12 pr-4 py-4 bg-slate-950/40 border border-slate-800 text-white rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all duration-300 placeholder-slate-700 text-sm"
                        placeholder="••••••••••••">
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs font-bold uppercase tracking-tight" />
            </div>

            <div class="flex items-center justify-between px-2">
                <label class="inline-flex items-center cursor-pointer group">
                    <input id="remember" type="checkbox" class="w-4 h-4 rounded-md bg-slate-950 border-slate-800 text-emerald-600 focus:ring-emerald-500/20 focus:ring-offset-slate-900 transition-all" name="remember">
                    <span class="ms-3 text-[10px] font-black text-slate-500 group-hover:text-emerald-500 transition-colors uppercase tracking-widest">Ingat Sesi</span>
                </label>
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="w-full relative flex items-center justify-center py-5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl shadow-[0_15px_40px_rgba(16,185,129,0.25)] transition-all duration-300 active:scale-[0.98] group overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>

                    <span wire:loading.remove wire:target="login" class="flex items-center gap-3 relative z-10">
                        <span class="text-sm font-black uppercase tracking-[0.4em] ml-1">Authorize System</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>

                    <span wire:loading wire:target="login" class="flex items-center relative z-10">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-black uppercase tracking-[0.2em]">Verifying...</span>
                    </span>
                </button>
            </div>
        </form>

        <div class="mt-12 text-center border-t border-slate-800/50 pt-8">
            <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.3em] leading-relaxed">
                KEJAKSAAN NEGERI SANGGAU
            </p>
            <p class="text-[8px] text-slate-600 font-bold uppercase tracking-[0.2em] mt-2">
                INTERNAL USE ONLY • SECURE ENVIRONMENT
            </p>
        </div>
    </div>
</div>