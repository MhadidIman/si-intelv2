<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-900 rounded-2xl shadow-2xl overflow-hidden border border-slate-700">
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
                </svg>
            </div>

            <div class="relative px-8 py-10 sm:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-left space-y-2">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-500/20 text-blue-300 text-xs font-semibold border border-blue-500/30">
                        Status Sistem: 🟢 Online
                    </span>
                    <h3 class="text-3xl font-bold text-white tracking-tight">Siap Bertugas, {{ Auth::user()->name }}!</h3>
                    <p class="text-slate-300 max-w-xl text-base leading-relaxed">
                        @if(Auth::user()->role === 'admin')
                        Anda memiliki <span class="text-yellow-400 font-bold">{{ $totalPending }}</span> item yang menunggu verifikasi.
                        @else
                        Selamat bekerja. Pastikan data yang diinput akurat dan terkini.
                        @endif
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('lapinhar.index') }}" wire:navigate class="bg-white/10 hover:bg-white/20 text-white border border-white/20 font-medium py-2.5 px-5 rounded-lg transition backdrop-blur-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Lapinhar
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 border-b-4 border-b-blue-500 hover:shadow-lg transition-all duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Lapinhar</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-blue-600 transition-colors">{{ $totalLapinhar }}</h4>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-xs">
                    <span class="text-slate-400">Total data masuk</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 border-b-4 border-b-red-500 hover:shadow-lg transition-all duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Buronan (DPO)</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-red-600 transition-colors">{{ $totalDpo }}</h4>
                    </div>
                    <div class="p-3 bg-red-50 rounded-lg text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-xs">
                    <span class="text-red-600 font-bold bg-red-50 px-1.5 py-0.5 rounded">Status: BURON</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 border-b-4 border-b-indigo-500 hover:shadow-lg transition-all duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ormas Aktif</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-indigo-600 transition-colors">{{ $totalOrmas }}</h4>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-xs">
                    <span class="text-slate-400">Terdaftar & Aktif</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 border-b-4 border-b-teal-500 hover:shadow-lg transition-all duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengawasan WNA</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-teal-600 transition-colors">{{ $totalWna }}</h4>
                    </div>
                    <div class="p-3 bg-teal-50 rounded-lg text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-xs">
                    <span class="text-slate-500 font-medium">Data WNA Masuk</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        5 Lapinhar Terakhir
                    </h3>
                    <a href="{{ route('lapinhar.index') }}" wire:navigate class="text-sm text-blue-600 font-semibold hover:text-blue-800 transition">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Perihal / Peristiwa</th>
                                <th class="px-6 py-3">Bidang</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latestLapinhar as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Str::limit($item->peristiwa, 40) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800">
                                        {{ $item->bidang }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status_verifikasi == 'disetujui')
                                    <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded border border-green-200">OK</span>
                                    @elseif($item->status_verifikasi == 'ditolak')
                                    <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded border border-red-200">TOLAK</span>
                                    @else
                                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">PENDING</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data Lapinhar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu Verifikasi
                    </h3>
                </div>
                <div class="p-6">
                    @if($totalPending > 0)
                    <div class="space-y-4">
                        @if($pending['lapinhar'] > 0)
                        <a href="{{ route('lapinhar.index') }}" wire:navigate class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition group">
                            <span class="text-sm font-medium text-blue-700">Lapinhar</span>
                            <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded shadow-sm group-hover:scale-110 transition">{{ $pending['lapinhar'] }}</span>
                        </a>
                        @endif

                        @if($pending['dpo'] > 0)
                        <a href="{{ route('dpo.index') }}" wire:navigate class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition group">
                            <span class="text-sm font-medium text-red-700">Data DPO</span>
                            <span class="bg-white text-red-600 text-xs font-bold px-2 py-1 rounded shadow-sm group-hover:scale-110 transition">{{ $pending['dpo'] }}</span>
                        </a>
                        @endif

                        @if($pending['ormas'] > 0)
                        <a href="{{ route('ormas.index') }}" wire:navigate class="flex items-center justify-between p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition group">
                            <span class="text-sm font-medium text-indigo-700">Data Ormas</span>
                            <span class="bg-white text-indigo-600 text-xs font-bold px-2 py-1 rounded shadow-sm group-hover:scale-110 transition">{{ $pending['ormas'] }}</span>
                        </a>
                        @endif

                        @if($pending['wna'] > 0)
                        <a href="{{ route('wna.index') }}" wire:navigate class="flex items-center justify-between p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition group">
                            <span class="text-sm font-medium text-teal-700">Data WNA</span>
                            <span class="bg-white text-teal-600 text-xs font-bold px-2 py-1 rounded shadow-sm group-hover:scale-110 transition">{{ $pending['wna'] }}</span>
                        </a>
                        @endif

                        @if($pending['jms'] > 0)
                        <a href="{{ route('jms.index') }}" wire:navigate class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition group">
                            <span class="text-sm font-medium text-purple-700">Giat JMS</span>
                            <span class="bg-white text-purple-600 text-xs font-bold px-2 py-1 rounded shadow-sm group-hover:scale-110 transition">{{ $pending['jms'] }}</span>
                        </a>
                        @endif

                        @if($pending['pam'] > 0)
                        <a href="{{ route('pam-sdo.index') }}" wire:navigate class="flex items-center justify-between p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition group">
                            <span class="text-sm font-medium text-gray-700">PAM SDO</span>
                            <span class="bg-white text-gray-600 text-xs font-bold px-2 py-1 rounded shadow-sm group-hover:scale-110 transition">{{ $pending['pam'] }}</span>
                        </a>
                        @endif
                    </div>
                    @else
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 text-green-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 font-medium">Semua data sudah diverifikasi.</p>
                        <p class="text-xs text-gray-400">Kerja bagus!</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>