<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SI-INTEL V2') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900"
    x-data="{ 
        sidebarOpen: window.innerWidth > 1024 ? (localStorage.getItem('sidebarState') === 'false' ? false : true) : false,
        isMobile: window.innerWidth < 1024
    }"
    x-init="
        $watch('sidebarOpen', value => { if(!isMobile) localStorage.setItem('sidebarState', value) });
        window.addEventListener('resize', () => { isMobile = window.innerWidth < 1024; if(isMobile) sidebarOpen = false });
    ">

    <div class="min-h-screen flex overflow-hidden">

        <div x-show="isMobile && sidebarOpen"
            x-transition:enter="transition opacity-ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity-ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] lg:hidden">
        </div>

        <aside
            :class="{
                'w-72': sidebarOpen && !isMobile,
                'w-20': !sidebarOpen && !isMobile,
                'translate-x-0 w-72': sidebarOpen && isMobile,
                '-translate-x-full': !sidebarOpen && isMobile
            }"
            class="bg-slate-900 border-r border-slate-800 flex-shrink-0 h-screen sticky top-0 transition-all duration-300 ease-in-out z-[70] shadow-2xl overflow-hidden fixed lg:sticky">
            <livewire:layout.navigation />
        </aside>

        <div class="flex-1 flex flex-col min-h-screen min-w-0 overflow-hidden">

            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-40 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-emerald-600 transition-all focus:outline-none border border-transparent hover:border-slate-200">
                        <svg class="w-6 h-6" :class="sidebarOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    @if (isset($header))
                    <div class="font-black text-slate-700 tracking-tight leading-none uppercase text-xs sm:text-sm md:text-lg border-l-2 border-slate-200 pl-4">
                        {{ $header }}
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right border-r border-slate-200 pr-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">{{ now()->translatedFormat('l') }}</p>
                        <p class="text-xs font-bold text-slate-700 leading-none mt-1">{{ now()->translatedFormat('d F Y') }}</p>
                    </div>

                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-700 flex items-center justify-center text-white text-sm font-black shadow-lg shadow-emerald-900/20 border border-emerald-400/20 transition-transform active:scale-95 cursor-pointer group relative">
                        @if(Auth::check())
                        {{ substr(Auth::user()->name, 0, 1) }}
                        <div class="absolute top-12 right-0 bg-slate-800 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50">
                            {{ Auth::user()->name }}
                        </div>
                        @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        @endif
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50">
                <div class="max-w-full mx-auto">
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                        x-show="show"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            // Memastikan state sidebar tetap konsisten setelah navigasi Livewire
            if (window.innerWidth < 1024) {
                window.dispatchEvent(new CustomEvent('close-sidebar'));
            }
        });
    </script>
</body>

</html>