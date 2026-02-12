<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI-INTELIZZ| Intelligence Operations System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-[#0f172a] text-white overflow-x-hidden font-sans selection:bg-emerald-500 selection:text-white">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 -left-40 w-[600px] h-[600px] bg-emerald-600/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 -right-40 w-[600px] h-[600px] bg-indigo-600/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-[0.04]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#0f172a]/50 to-[#0f172a]"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col">

        <nav class="px-6 md:px-12 h-24 flex items-center justify-between border-b border-white/5 bg-[#0f172a]/70 backdrop-blur-xl sticky top-0 z-50 transition-all duration-300">
            <div class="flex items-center gap-5">
                <div class="p-2 bg-white rounded-xl shadow-lg shadow-emerald-500/10 hover:shadow-emerald-500/20 transition-shadow duration-300">
                    <img src="{{ asset('img/logo-kejaksaan.png') }}" class="h-10 w-auto" alt="Logo Kejaksaan">
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-xl font-black tracking-tighter leading-none italic uppercase text-slate-100">
                        SI-INTEL<span class="text-emerald-500 not-italic ml-0.5">LIZZ</span>
                    </h1>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.4em] mt-1">Intelligence Hub</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="group flex items-center gap-3 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-emerald-900/40 active:scale-95 ring-1 ring-emerald-500/50">
                    Buka Dashboard
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                @else
                <a href="{{ route('login') }}" class="group flex items-center gap-3 px-8 py-3 bg-slate-800/80 hover:bg-slate-700 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-slate-700 hover:border-emerald-500/30 shadow-xl hover:shadow-emerald-500/10 active:scale-95 backdrop-blur-sm">
                    <svg class="w-4 h-4 text-emerald-500 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="group-hover:text-white transition-colors">Otorisasi Masuk</span>
                </a>
                @endauth
                @endif
            </div>
        </nav>

        <main class="flex-1 flex flex-col items-center justify-center px-6 text-center py-20 relative">
            <div class="max-w-5xl space-y-12 relative z-10">

                <div class="inline-flex items-center px-5 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-emerald-400 shadow-[0_0_30px_rgba(16,185,129,0.15)] backdrop-blur-sm animate-fade-in-up">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping mr-3"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em]">Official Intelligence Terminal</span>
                </div>

                <div class="space-y-6">
                    <h2 class="text-5xl md:text-7xl lg:text-8xl font-black tracking-tighter leading-[0.9] italic uppercase drop-shadow-2xl">
                        OPERASI DIGITAL <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-400 to-indigo-500 drop-shadow-lg animate-gradient">
                            INTELIJEN TERPADU
                        </span>
                    </h2>
                    <div class="h-1.5 w-32 md:w-48 bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-600 mx-auto rounded-full shadow-lg shadow-emerald-500/30"></div>
                </div>

                <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto font-medium leading-relaxed tracking-wide">
                    Sistem kendali terpusat untuk monitoring peristiwa harian, pengawasan orang asing,
                    dan manajemen sumber daya organisasi secara <span class="text-emerald-400 font-bold">real-time</span> dan aman.
                </p>

                <div class="pt-8">
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center gap-4 px-12 py-5 bg-emerald-600 hover:bg-emerald-500 rounded-2xl transition-all shadow-[0_20px_50px_rgba(5,150,105,0.3)] hover:shadow-[0_20px_50px_rgba(5,150,105,0.5)] active:scale-95 overflow-hidden ring-1 ring-emerald-400/50">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></div>
                        <span class="text-sm font-black uppercase tracking-[0.3em] relative z-10 text-white">Akses Terminal Utama</span>
                        <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300 relative z-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </main>

        <footer class="px-8 md:px-12 py-10 border-t border-white/5 bg-[#0b0f1a]/90 backdrop-blur-xl relative z-20">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 items-center text-[10px]">

                <div class="text-center md:text-left space-y-2">
                    <p class="text-slate-500 font-black uppercase tracking-[0.3em]">Satuan Kerja</p>
                    <p class="text-sm font-bold text-slate-200 tracking-wide border-b border-dashed border-slate-700 pb-1 inline-block">
                        KEJAKSAAN NEGERI BANJARMASIN
                    </p>
                </div>

                <div class="flex justify-center items-center gap-8">
                    <div class="text-center group cursor-default">
                        <p class="text-emerald-500 text-2xl font-black tracking-tighter group-hover:scale-110 transition-transform duration-300">2026</p>
                        <p class="text-slate-500 font-black uppercase tracking-[0.3em] mt-1">Version 2.0</p>
                    </div>
                    <div class="h-10 w-px bg-white/10"></div>
                    <div class="text-center group cursor-default">
                        <p class="text-indigo-500 text-2xl font-black italic uppercase tracking-tighter group-hover:scale-110 transition-transform duration-300">Secure</p>
                        <p class="text-slate-500 font-black uppercase tracking-[0.3em] mt-1">Encryption</p>
                    </div>
                </div>

                <div class="text-center md:text-right space-y-2">
                    <p class="text-slate-500 font-black uppercase tracking-[0.3em]">Otoritas Sistem</p>
                    <p class="text-sm font-bold text-slate-200 tracking-wide italic">
                        &copy; Bidang Intelijen Kejari Banjarmasin
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>