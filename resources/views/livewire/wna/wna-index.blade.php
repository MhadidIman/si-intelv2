<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-100 rounded-xl text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Pengawasan WNA</h2>
                    <p class="text-sm text-slate-500 font-medium tracking-wide">Monitoring Aktivitas & Legalitas Orang Asing</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.wna') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all border border-slate-300">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                <button wire:click="create"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Input Data
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-bold uppercase tracking-widest">{{ session('message') }}</span>
        </div>
        @endif

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                placeholder="Cari nama WNA, negara asal, atau nomor paspor..."
                class="block w-full pl-11 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm font-medium">
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-500">PROFIL</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500">IDENTITAS PASPOR</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500">KUNJUNGAN & SPONSOR</th>
                            <th class="px-6 py-4 text-center font-black text-slate-500">STATUS VERIFIKASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-500">OPSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($wnas as $item)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if($item->foto)
                                    <img class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-md" src="{{ asset('storage/' . $item->foto) }}">
                                    @else
                                    <div class="h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-300 border border-indigo-100">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-black text-slate-800 text-sm tracking-normal normal-case">{{ strtoupper($item->nama_lengkap) }}</div>
                                        <div class="text-indigo-600 font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                            </svg>
                                            {{ $item->negara_asal }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-700">{{ $item->nomor_paspor }}</div>
                                <div class="text-slate-400 font-medium tracking-normal normal-case">Lahir: {{ $item->tempat_lahir }}, {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 tracking-normal normal-case">{{ $item->tujuan_kunjungan }}</div>
                                <div class="mt-1 flex flex-col gap-0.5">
                                    <span class="text-indigo-600 font-black">IZIN S.D: {{ \Carbon\Carbon::parse($item->masa_berlaku_izin)->format('d M Y') }}</span>
                                    <span class="text-slate-400 italic tracking-normal normal-case">Sponsor: {{ $item->sponsor ?? 'Mandiri' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                $vStatus = [
                                'disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'ditolak' => 'bg-rose-50 text-rose-600 border-rose-200',
                                'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-lg font-black border {{ $vStatus[$item->status_verifikasi] ?? 'bg-slate-50' }}">
                                    {{ strtoupper($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('reports.wna.satuan', $item->id) }}" target="_blank" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-all active:scale-95">
                                        VERIFIKASI
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data pengawasan WNA ini?" class="p-2 text-rose-400 hover:text-rose-600">
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
                                        <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <p class="text-slate-400 font-black uppercase tracking-widest text-[10px]">Basis Data WNA Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $wnas->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-slate-200">
                <div class="bg-indigo-700 px-8 py-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">
                            {{ $is_edit ? 'Form Pembaruan Data WNA' : 'Registrasi Orang Asing Baru' }}
                        </h3>
                        <p class="text-indigo-100 text-xs mt-1">Gunakan data Paspor/KITAS yang valid untuk input identitas.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-indigo-200 hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap Sesuai Paspor</label>
                                <input type="text" wire:model="nama_lengkap" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3">
                                @error('nama_lengkap') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Negara Asal</label>
                                    <input type="text" wire:model="negara_asal" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3" placeholder="Contoh: Amerika Serikat">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nomor Paspor</label>
                                    <input type="text" wire:model="nomor_paspor" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tempat Lahir</label>
                                    <input type="text" wire:model="tempat_lahir" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Lahir</label>
                                    <input type="date" wire:model="tanggal_lahir" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3">
                                </div>
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-slate-900 rounded-2xl border border-slate-800">
                                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4 text-center">Otoritas Verifikasi</label>
                                <div class="flex gap-2">
                                    @foreach(['pending' => 'PENDING', 'disetujui' => 'SETUJUI', 'ditolak' => 'TOLAK'] as $key => $label)
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" wire:model="status_verifikasi" value="{{ $key }}" class="hidden peer">
                                        <div class="text-center py-2 text-[10px] font-black rounded-lg border border-slate-700 text-slate-500 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all">
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
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tujuan Kunjungan</label>
                                <input type="text" wire:model="tujuan_kunjungan" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3" placeholder="Contoh: Tenaga Kerja Asing, Wisata, Pendidikan">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Sponsor/Penjamin</label>
                                    <input type="text" wire:model="sponsor" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3" placeholder="PT. Nama Perusahaan">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Masa Berlaku Izin</label>
                                    <input type="date" wire:model="masa_berlaku_izin" class="w-full bg-slate-50 border-indigo-100 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3 font-bold text-indigo-700">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Tinggal di Indonesia</label>
                                <textarea wire:model="tempat_tinggal" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 px-4 py-3 resize-none" placeholder="Alamat lengkap hotel atau rumah tinggal..."></textarea>
                            </div>

                            <div class="p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Dokumentasi Wajah/Paspor</label>
                                <div class="flex items-center gap-6">
                                    <div class="h-16 w-16 rounded-xl bg-white shadow-sm border border-slate-200 flex items-center justify-center overflow-hidden">
                                        @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="object-cover h-full w-full">
                                        @elseif ($old_foto)
                                        <img src="{{ asset('storage/' . $old_foto) }}" class="object-cover h-full w-full">
                                        @else
                                        <svg class="w-8 h-8 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" wire:model="foto" class="text-[10px] text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                        <div wire:loading wire:target="foto" class="text-[9px] text-indigo-600 font-black animate-pulse mt-2 uppercase">Syncing...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-[10px] font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest">Batal</button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-10 py-3 bg-indigo-700 hover:bg-indigo-800 text-white text-[10px] font-black rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2">
                        <span wire:loading.remove wire:target="store">SIMPAN DATA PENGAWASAN</span>
                        <span wire:loading wire:target="store" class="animate-spin h-3 w-3 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>