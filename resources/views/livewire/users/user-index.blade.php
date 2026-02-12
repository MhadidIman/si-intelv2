<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-100 rounded-xl text-emerald-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Manajemen Personil</h2>
                    <p class="text-sm text-slate-500 font-medium tracking-wide">Otoritas Pengelolaan Akun Jaksa & Staff Intelijen</p>
                </div>
            </div>

            <button wire:click="create"
                class="inline-flex items-center px-6 py-3 bg-slate-900 hover:bg-black text-white text-xs font-black uppercase tracking-[0.2em] rounded-xl shadow-xl transition-all active:scale-95 group">
                <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Anggota
            </button>
        </div>

        @if (session()->has('message'))
        <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl animate-in fade-in slide-in-from-top-4">
            <div class="p-1 bg-emerald-500 rounded-full mr-3 text-white">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <span class="text-xs font-black uppercase tracking-widest">{{ session('message') }}</span>
        </div>
        @endif

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                placeholder="Cari berdasarkan Nama, NIP, Jabatan atau NRP..."
                class="block w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm font-medium">
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-5 text-left font-black text-slate-400">IDENTITAS PERSONIL</th>
                            <th class="px-6 py-5 text-left font-black text-slate-400">NOMOR INDUK</th>
                            <th class="px-6 py-5 text-left font-black text-slate-400">JABATAN & GOLONGAN</th>
                            <th class="px-6 py-5 text-center font-black text-slate-400">ROLE SISTEM</th>
                            <th class="px-8 py-5 text-right font-black text-slate-400">MANAGE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative shrink-0 group-hover:scale-110 transition-transform">
                                        @if($user->foto_profil)
                                        <img class="h-12 w-12 rounded-2xl object-cover border-2 border-white shadow-md" src="{{ asset('storage/' . $user->foto_profil) }}">
                                        @else
                                        <div class="h-12 w-12 rounded-2xl bg-emerald-500 flex items-center justify-center text-white font-black text-lg border-2 border-emerald-400 shadow-lg">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        <div class="absolute -bottom-1 -right-1 h-4 w-4 {{ $user->role === 'admin' ? 'bg-blue-500' : 'bg-emerald-500' }} border-2 border-white rounded-full"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 tracking-normal normal-case">{{ $user->name }}</div>
                                        <div class="text-slate-400 font-medium tracking-normal normal-case lowercase">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-black text-slate-700 tracking-[0.1em]">{{ $user->nip ?? 'NIP TIDAK ADA' }}</div>
                                <div class="text-[10px] text-emerald-600 font-black mt-1">NRP: {{ $user->nrp ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-black text-slate-700 tracking-normal normal-case">{{ strtoupper($user->jabatan) }}</div>
                                <div class="text-slate-400 font-medium tracking-normal normal-case mt-0.5">{{ $user->pangkat_golongan }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 rounded-lg font-black text-[9px] {{ $user->role === 'admin' ? 'bg-blue-900 text-blue-200 border border-blue-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ strtoupper($user->role ?? 'STAF') }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-3 items-center">
                                    <button wire:click="edit({{ $user->id }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Ubah Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $user->id }})"
                                        wire:confirm="Konfirmasi: Menghapus data personil akan memutuskan akses login. Lanjutkan?"
                                        class="p-2 text-rose-300 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Hapus Akun">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center border-2 border-dashed border-slate-200 mb-4 text-slate-200">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-[10px]">Data Personil Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-4 bg-slate-50 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="relative inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-slate-200 animate-in fade-in zoom-in duration-300">

                <div class="bg-slate-900 px-10 py-8 flex justify-between items-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest italic">
                            {{ $is_edit ? 'Modifikasi Data Personil' : 'Registrasi Anggota Baru' }}
                        </h3>
                        <p class="text-emerald-500 text-[10px] font-bold uppercase tracking-[0.3em] mt-1">Intelligence Database Interface</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-slate-500 hover:text-white transition-colors relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-white px-10 py-10">

                    @if ($errors->any())
                    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-xl flex items-start gap-3 animate-pulse">
                        <div class="text-rose-500 shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-rose-700 uppercase tracking-widest mb-1">Terdapat Kesalahan Input!</h4>
                            <ul class="list-disc list-inside text-[11px] text-rose-600 font-medium">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] flex items-center gap-2">
                                <span class="h-px w-8 bg-emerald-200"></span> Bio Data Pegawai
                            </h4>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                                <input type="text" wire:model="name" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 font-bold px-5 py-3.5 @error('name') border-rose-500 bg-rose-50 @enderror" placeholder="Sesuai SK Jabatan">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">NIP (18 DIGIT)</label>
                                    <input type="text" wire:model="nip" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 px-5 py-3.5 font-black tracking-widest @error('nip') border-rose-500 bg-rose-50 @enderror">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">NRP (JAKSA)</label>
                                    <input type="text" wire:model="nrp" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 px-5 py-3.5">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Komunikasi (WhatsApp)</label>
                                <input type="text" wire:model="no_hp" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 px-5 py-3.5" placeholder="08XXXXXXXXXX">
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] flex items-center gap-2">
                                <span class="h-px w-8 bg-emerald-200"></span> Otoritas & Jabatan
                            </h4>

                            <div class="flex items-center gap-6 p-5 bg-slate-50 rounded-[2rem] border border-slate-100 shadow-inner group">
                                <div class="relative h-20 w-20 shrink-0">
                                    @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="h-full w-full object-cover rounded-2xl border-2 border-emerald-500 shadow-lg">
                                    @elseif ($old_foto)
                                    <img src="{{ asset('storage/' . $old_foto) }}" class="h-full w-full object-cover rounded-2xl border-2 border-slate-200">
                                    @else
                                    <div class="h-full w-full bg-slate-200 rounded-2xl flex items-center justify-center text-slate-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <input type="file" wire:model="foto" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Ubah Foto Profil</label>
                                    <p class="text-[10px] text-slate-500 leading-tight">Klik ikon di samping untuk mengunggah foto resmi (PNG/JPG).</p>
                                    <div wire:loading wire:target="foto" class="text-[9px] text-emerald-600 font-black animate-pulse mt-2">UPLOADING...</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Pangkat / Gol. <span class="text-rose-500">*</span></label>
                                    <select wire:model="pangkat_golongan" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-[11px] focus:ring-emerald-500 font-bold px-4 py-3.5 @error('pangkat_golongan') border-rose-500 @enderror">
                                        <option value="">-- PILIH --</option>
                                        <option value="Jaksa Utama (IV/e)">Jaksa Utama (IV/e)</option>
                                        <option value="Jaksa Madya (IV/a)">Jaksa Madya (IV/a)</option>
                                        <option value="Penata Muda (III/a)">Penata Muda (III/a)</option>
                                        <option value="Staff Tata Usaha">Staff Tata Usaha</option>
                                        <option value="PPNPN">PPNPN (Honorer)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Role Akses <span class="text-rose-500">*</span></label>
                                    <select wire:model="role" class="w-full bg-slate-900 border-slate-800 text-emerald-400 rounded-2xl text-[11px] focus:ring-emerald-500 font-black px-4 py-3.5 uppercase tracking-widest @error('role') border-rose-500 @enderror">
                                        <option value="staff">USER / STAF</option>
                                        <option value="admin">ADMINISTRATOR</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Jabatan Struktural <span class="text-rose-500">*</span></label>
                                <input type="text" wire:model="jabatan" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 px-5 py-3.5 font-bold @error('jabatan') border-rose-500 bg-rose-50 @enderror" placeholder="Contoh: Kasi Intelijen">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Email Terminal <span class="text-rose-500">*</span></label>
                                    <input type="email" wire:model="email" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 px-5 py-3.5 @error('email') border-rose-500 bg-rose-50 @enderror">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Password</label>
                                    <input type="password" wire:model="password" class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-emerald-500 px-5 py-3.5 @error('password') border-rose-500 bg-rose-50 @enderror" placeholder="{{ $is_edit ? 'Biarkan kosong jika tetap' : 'Min. 6 Karakter' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-10 py-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-3 text-[10px] font-black text-slate-400 hover:text-slate-600 uppercase tracking-[0.2em] transition-colors">Batal</button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-12 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black rounded-2xl shadow-xl shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2">
                        <span wire:loading.remove wire:target="store">AUTHORIZE & SAVE DATA</span>
                        <span wire:loading wire:target="store" class="animate-spin h-3 w-3 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>