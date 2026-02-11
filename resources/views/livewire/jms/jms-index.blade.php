<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-xl text-purple-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Jaksa Masuk Sekolah</h2>
                    <p class="text-sm text-slate-500 font-medium tracking-wide">Program Binmatkum: Kenali Hukum, Jauhi Hukuman</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.jms') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all border border-slate-300">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                <button wire:click="create"
                    class="inline-flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-purple-600/20 transition-all active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Input Kegiatan
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-bold uppercase tracking-widest">{{ session('message') }}</span>
        </div>
        @endif

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                placeholder="Cari berdasarkan nama sekolah, materi edukasi, atau narasumber..."
                class="block w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all shadow-sm font-medium">
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-500">SEKOLAH & TANGGAL</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500">MATERI & AUDIENS</th>
                            <th class="px-6 py-4 text-center font-black text-slate-500">VERIFIKASI</th>
                            <th class="px-6 py-4 text-center font-black text-slate-500">DOKUMENTASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-500">OPSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($jms as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-800 text-sm tracking-normal normal-case">{{ $item->nama_sekolah }}</div>
                                <div class="text-purple-600 font-bold mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 tracking-normal normal-case line-clamp-1 italic">"{{ $item->materi }}"</div>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 font-black text-[9px]">
                                        {{ $item->jumlah_peserta }} PESERTA
                                    </span>
                                    <span class="text-slate-400 font-medium tracking-normal normal-case text-[10px]">Oleh: {{ $item->narasumber }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                $vStatus = [
                                'disetujui' => 'bg-emerald-500 text-white',
                                'ditolak' => 'bg-rose-500 text-white',
                                'pending' => 'bg-amber-100 text-amber-700 border border-amber-200',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-lg font-black text-[9px] {{ $vStatus[$item->status_verifikasi] ?? 'bg-slate-100' }}">
                                    {{ strtoupper($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->foto_kegiatan)
                                <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-md mx-auto hover:rotate-3 transition-transform cursor-pointer" src="{{ asset('storage/' . $item->foto_kegiatan) }}">
                                @else
                                <div class="h-10 w-10 bg-slate-50 rounded-lg border border-dashed border-slate-200 mx-auto flex items-center justify-center text-slate-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('reports.jms.satuan', $item->id) }}" target="_blank" class="p-2 text-slate-400 hover:text-slate-900 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-all active:scale-95">
                                        VALIDASI
                                    </button>
                                    @elseif(auth()->id() === $item->user_id)
                                    <button wire:click="edit({{ $item->id }})" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus dokumentasi JMS ini?" class="p-2 text-rose-300 hover:text-rose-600">
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
                                <p class="text-slate-400 font-black uppercase tracking-widest text-[10px]">Belum ada catatan kegiatan Jaksa Masuk Sekolah</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">{{ $jms->links() }}</div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-slate-200">
                <div class="bg-purple-700 px-8 py-6 flex justify-between items-center shadow-lg">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tight italic">LOG KEGIATAN JMS</h3>
                        <p class="text-purple-100 text-[10px] font-bold uppercase tracking-widest mt-1">Sosialisasi & Penyuluhan Hukum Masyarakat</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-purple-200 hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Nama Instansi Pendidikan / Sekolah</label>
                                <input type="text" wire:model="nama_sekolah" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-purple-500 px-4 py-3 font-bold text-slate-800" placeholder="Contoh: SMA Negeri 1 ...">
                                @error('nama_sekolah') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Tanggal Pelaksanaan</label>
                                    <input type="date" wire:model="tanggal_kegiatan" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-purple-500 px-4 py-3">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Estimasi Audiens</label>
                                    <input type="number" wire:model="jumlah_peserta" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-purple-500 px-4 py-3 font-bold" placeholder="0">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Ringkasan Hasil Kegiatan</label>
                                <textarea wire:model="keterangan" rows="5" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-purple-500 px-4 py-3 resize-none" placeholder="Uraikan respon siswa dan jalannya acara..."></textarea>
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-slate-900 rounded-2xl border border-slate-800 shadow-inner">
                                <label class="block text-[10px] font-black text-purple-400 uppercase tracking-[0.3em] mb-4 text-center">Verifikasi Hasil Binmatkum</label>
                                <div class="flex gap-2">
                                    @foreach(['pending' => 'PENDING', 'disetujui' => 'VALIDASI', 'ditolak' => 'REVISI'] as $key => $label)
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" wire:model="status_verifikasi" value="{{ $key }}" class="hidden peer">
                                        <div class="text-center py-2.5 text-[10px] font-black rounded-lg border border-slate-700 text-slate-500 peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 transition-all">
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
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Tema / Materi Sosialisasi</label>
                                <input type="text" wire:model="materi" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-purple-500 px-4 py-3 font-bold italic" placeholder="Contoh: Bahaya Narkoba & Cyber Bullying">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Narasumber / Tim Pelaksana</label>
                                <input type="text" wire:model="narasumber" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-purple-500 px-4 py-3" placeholder="Nama-nama Jaksa/Staf pengisi materi">
                            </div>

                            <div class="p-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 text-center">Visual Dokumentasi (Foto Giat)</label>
                                <div class="flex flex-col items-center gap-4">
                                    <div class="h-40 w-full rounded-2xl bg-white shadow-inner border border-slate-200 flex items-center justify-center overflow-hidden relative group">
                                        @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="object-cover h-full w-full">
                                        @elseif ($old_foto)
                                        <img src="{{ asset('storage/' . $old_foto) }}" class="object-cover h-full w-full">
                                        @else
                                        <svg class="w-12 h-12 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                        @endif
                                        <div class="absolute inset-0 bg-purple-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-[10px] font-black tracking-widest">GANTI DOKUMEN</span>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <input type="file" wire:model="foto" class="text-[10px] text-slate-500 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer w-full transition-all">
                                        <div wire:loading wire:target="foto" class="text-[9px] text-purple-600 font-black animate-pulse mt-2 text-center uppercase tracking-widest">Optimizing Assets...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-3 text-[10px] font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest">BATAL</button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-12 py-3 bg-purple-700 hover:bg-purple-800 text-white text-[10px] font-black rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2">
                        <span wire:loading.remove wire:target="store">SIMPAN DOKUMEN JMS</span>
                        <span wire:loading wire:target="store" class="animate-spin h-3 w-3 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>