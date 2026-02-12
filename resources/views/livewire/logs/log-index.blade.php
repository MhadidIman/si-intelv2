<div class="min-h-screen bg-gray-50 font-sans selection:bg-emerald-500 selection:text-white pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-8 border-b border-gray-200 pb-8">
            <div class="relative">
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">
                    Audit <span class="text-emerald-600 not-italic">Trails</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] mt-1">
                    System Security & User Activity Logs
                </p>
                <div class="absolute -left-4 top-1 h-8 w-1 bg-emerald-500 rounded-full"></div>
            </div>

            <div class="w-full md:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-emerald-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="block w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-xs font-bold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm uppercase tracking-wider"
                    placeholder="Search Log ID / IP / Activity...">
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden relative">

            <div class="overflow-x-auto relative z-10">
                <table class="min-w-full divide-y divide-gray-100 text-left">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Waktu</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Aktor</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Aktifitas</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Deskripsi</th>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Terminal IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors group">

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-800 font-mono tracking-tight group-hover:text-emerald-600 transition-colors">
                                        {{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}
                                    </span>
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">
                                        {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->user_name)
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[10px] font-black text-emerald-600 shadow-sm">
                                        {{ substr($log->user_name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-700">{{ $log->user_name }}</span>
                                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ $log->user_role ?? 'STAFF' }}</span>
                                    </div>
                                </div>
                                @else
                                <div class="flex items-center gap-3 opacity-60">
                                    <div class="h-8 w-8 rounded-lg bg-gray-100 border border-gray-200 border-dashed flex items-center justify-center text-[10px] text-gray-400">?</div>
                                    <span class="text-[10px] font-bold text-gray-400 italic uppercase">System / Guest</span>
                                </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $act = strtoupper($log->activity);
                                $style = match(true) {
                                str_contains($act, 'HAPUS') || str_contains($act, 'DELETE') || str_contains($act, 'GAGAL') => 'bg-rose-50 text-rose-600 border-rose-200',
                                str_contains($act, 'LOGIN') => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                str_contains($act, 'LOGOUT') => 'bg-gray-100 text-gray-500 border-gray-200',
                                str_contains($act, 'UPDATE') || str_contains($act, 'EDIT') => 'bg-amber-50 text-amber-600 border-amber-200',
                                default => 'bg-blue-50 text-blue-600 border-blue-200',
                                };
                                @endphp
                                <span class="px-2.5 py-1 rounded-md border text-[9px] font-black uppercase tracking-widest {{ $style }}">
                                    {{ $log->activity }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-xs font-medium text-slate-500 truncate max-w-xs group-hover:text-slate-800 transition-colors">
                                    {{ $log->description }}
                                </p>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="font-mono text-[10px] font-bold text-slate-500 bg-gray-50 px-2 py-1 rounded border border-gray-200 group-hover:border-emerald-200 transition-colors">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center justify-center opacity-40">
                                    <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tidak ada data ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 relative z-10">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</div>