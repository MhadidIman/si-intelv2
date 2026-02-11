<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <span class="p-2 bg-blue-600 rounded-lg mr-3 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </span>
                {{ __('Command Center Intelijen') }}
            </h2>
            <div class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl shadow-xl mb-8 overflow-hidden">
                <div class="px-8 py-10 relative">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-blue-100 max-w-2xl text-lg">
                            Sistem Informasi Intelijen (SI-INTEL) siap digunakan. Pantau laporan informasi harian dan cegah potensi gangguan keamanan secara dini.
                        </p>
                    </div>
                    <div class="absolute right-0 top-0 opacity-10 -mr-16 -mt-16">
                        <svg width="400" height="400" fill="white" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="50" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path>
                            </svg>
                        </div>
                        <span class="flex items-center text-green-500 text-xs font-bold bg-green-50 px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <div class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Lapinhar</div>
                    <div class="mt-1 text-3xl font-extrabold text-gray-900">128</div>
                    <p class="text-xs text-gray-400 mt-2 italic">*Data masuk bulan ini</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <span class="text-red-500 text-xs font-bold">High Priority</span>
                    </div>
                    <div class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Buronan (DPO)</div>
                    <div class="mt-1 text-3xl font-extrabold text-gray-900">14</div>
                    <p class="text-xs text-gray-400 mt-2 italic">*Target Operasi (Tabur)</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Pengaduan (Lapdu)</div>
                    <div class="mt-1 text-3xl font-extrabold text-gray-900">42</div>
                    <p class="text-xs text-gray-400 mt-2 italic">*Menunggu Verifikasi</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Personil Aktif</div>
                    <div class="mt-1 text-3xl font-extrabold text-gray-900">28</div>
                    <p class="text-xs text-gray-400 mt-2 italic">*Tersebar di wilayah hukum</p>
                </div>
            </div>

            <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Laporan Informasi Terbaru</h3>
                    <a href="#" class="text-sm text-blue-600 font-semibold hover:underline">Lihat Semua</a>
                </div>
                <div class="p-6">
                    <p class="text-center text-gray-400 py-10">Belum ada data laporan terbaru hari ini.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>