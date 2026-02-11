<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">LAPINHAR</h2>
                <p class="text-sm text-slate-500 font-medium">Laporan Informasi Harian & Analisa Intelijen</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.lapinhar') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all border border-slate-300">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                <button wire:click="create"
                    class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-600/20 transition-all active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Laporan Baru
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl animate-pulse">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-bold">{{ session('message') }}</span>
        </div>
        @endif

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                placeholder="Cari nomor surat, peristiwa, atau bidang intelijen..."
                class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl leading-5 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all shadow-sm">
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-500">IDENTITAS SURAT</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500">BIDANG</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500 w-1/3">ISI PERISTIWA</th>
                            <th class="px-6 py-4 text-center font-black text-slate-500">STATUS VERIFIKASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-500">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($lapinhars as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-800">{{ $item->tanggal_surat->format('d/m/Y') }}</div>
                                <div class="text-slate-400 font-medium">{{ $item->nomor_surat }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-bold border border-slate-200">
                                    {{ $item->bidang }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-700 font-semibold line-clamp-2 italic tracking-normal normal-case">{{ $item->peristiwa }}</div>
                                <div class="text-green-600 font-bold mt-1 tracking-widest">SUMBER: {{ $item->sumber_informasi }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                $statusClasses = [
                                'disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'ditolak' => 'bg-rose-50 text-rose-600 border-rose-200',
                                'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full font-black border {{ $statusClasses[$item->status_verifikasi] ?? 'bg-slate-50' }}">
                                    {{ strtoupper($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('reports.lapinhar.satuan', $item->id) }}" target="_blank"
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Download PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-slate-800 hover:bg-black text-white px-3 py-1.5 rounded-lg font-bold transition-all">
                                        VERIFIKASI
                                    </button>
                                    @elseif(auth()->id() === $item->user_id)
                                    <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus dokumen intelijen ini?" class="text-rose-400 hover:text-rose-600 p-2 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-slate-400 font-medium">Belum ada arsip LAPINHAR yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $lapinhars->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto" x-data="{ open: true }">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden transition-all border border-slate-200">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">
                        {{ $is_edit ? 'Form Verifikasi & Edit' : 'Penyusunan Laporan Baru' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Nomor Surat</label>
                                <input type="text" wire:model="nomor_surat" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500 transition-all px-4 py-2.5" placeholder="R-XXX/O.3.10/Dek.1/MM/YYYY">
                                @error('nomor_surat') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal</label>
                                    <input type="date" wire:model="tanggal_surat" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Bidang</label>
                                    <select wire:model="bidang" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5">
                                        <option value="">-- Pilih --</option>
                                        <option value="Ideologi">Ideologi</option>
                                        <option value="Politik">Politik</option>
                                        <option value="Ekonomi">Ekonomi</option>
                                        <option value="Sosial Budaya">Sosial Budaya</option>
                                        <option value="Pertahanan Keamanan">Hankam</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Sumber Informasi</label>
                                <input type="text" wire:model="sumber_informasi" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5" placeholder="Contoh: Media Massa, Laporan Masyarakat">
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-slate-900 rounded-2xl border border-slate-800">
                                <label class="block text-[10px] font-black text-green-500 uppercase tracking-[0.3em] mb-4">Otoritas Verifikasi Pimpinan</label>
                                <div class="flex gap-2">
                                    @foreach(['pending' => 'PENDING', 'disetujui' => 'SETUJUI', 'ditolak' => 'TOLAK'] as $key => $label)
                                    <label class="flex-1">
                                        <input type="radio" wire:model="status_verifikasi" value="{{ $key }}" class="hidden peer">
                                        <div class="text-center py-2 text-[10px] font-black rounded-lg border border-slate-700 text-slate-500 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 cursor-pointer transition-all">
                                            {{ $label }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Peristiwa / Fakta-Fakta</label>
                                <textarea wire:model="peristiwa" rows="5" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-3 resize-none" placeholder="Uraikan peristiwa secara detail..."></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Analisa / Saran</label>
                                <textarea wire:model="pendapat" rows="5" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-3 resize-none" placeholder="Masukan analisa intelijen Anda..."></textarea>
                            </div>
                            <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Sifat Laporan:</label>
                                <div class="flex gap-4">
                                    <label class="inline-flex items-center group cursor-pointer">
                                        <input type="radio" wire:model="status" value="rahasia" class="text-rose-600 focus:ring-rose-500">
                                        <span class="ml-2 text-xs font-bold text-slate-700">RAHASIA</span>
                                    </label>
                                    <label class="inline-flex items-center group cursor-pointer">
                                        <input type="radio" wire:model="status" value="biasa" class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-xs font-bold text-slate-700">BIASA</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                        Batal
                    </button>
                    <button type="button" wire:click="store" class="px-8 py-2.5 bg-slate-900 hover:bg-black text-white text-sm font-black rounded-xl shadow-lg transition-all active:scale-95">
                        Simpan Dokumen
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>