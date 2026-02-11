<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Personil</h2>
                <p class="text-sm text-gray-500">Kelola data Jaksa, Staff, dan Admin Sistem.</p>
            </div>
            <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg flex items-center transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Personil
            </button>
        </div>

        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm rounded-r" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('message') }}</p>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-4 flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input wire:model.live="search" type="text" placeholder="Cari berdasarkan Nama, NIP, atau Jabatan..." class="w-full border-none focus:ring-0 text-gray-700 placeholder-gray-400" style="outline: none;">
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Identitas Pegawai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP / NRP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->foto_profil)
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . $user->foto_profil) }}" alt="">
                                        @else
                                        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->nip ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $user->nrp ? 'NRP: ' . $user->nrp : '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $user->jabatan }}</div>
                                <div class="text-xs text-gray-500">{{ $user->pangkat_golongan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mr-4 font-bold">Edit</button>
                                <button wire:click="delete({{ $user->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus data pegawai ini? Data yang dihapus tidak dapat dikembalikan."
                                    class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="text-lg">Belum ada data personil.</span>
                                    <span class="text-sm">Silakan klik tombol tambah di atas.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">

                <div class="bg-slate-900 px-4 py-3 sm:px-6">
                    <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                        {{ $is_edit ? 'Edit Data Personil' : 'Tambah Personil Baru' }}
                    </h3>
                </div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-700 border-b pb-2">Identitas Pegawai</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Contoh: Jaksa Fulan, S.H., M.H.">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIP (18 Digit)</label>
                                <input type="number" wire:model="nip" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('nip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">NRP (Khusus Jaksa)</label>
                                <input type="text" wire:model="nrp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor HP / WhatsApp</label>
                                <input type="number" wire:model="no_hp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-700 border-b pb-2">Jabatan & Akun Sistem</h4>

                            <div class="flex items-start space-x-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-shrink-0">
                                    @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="h-16 w-16 rounded-full object-cover border-2 border-green-500">
                                    @elseif ($old_foto)
                                    <img src="{{ asset('storage/' . $old_foto) }}" class="h-16 w-16 rounded-full object-cover border-2 border-gray-300">
                                    @else
                                    <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                                    <input type="file" wire:model="foto" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                    <div wire:loading wire:target="foto" class="text-xs text-blue-500 mt-1 font-semibold">Sedang mengupload...</div>
                                    @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pangkat / Golongan <span class="text-red-500">*</span></label>
                                <select wire:model="pangkat_golongan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Pilih Pangkat --</option>
                                    <option value="Jaksa Utama (IV/e)">Jaksa Utama (IV/e)</option>
                                    <option value="Jaksa Madya (IV/a)">Jaksa Madya (IV/a)</option>
                                    <option value="Jaksa Pratama (III/c)">Jaksa Pratama (III/c)</option>
                                    <option value="Penata Muda (III/a)">Penata Muda (III/a)</option>
                                    <option value="Pengatur (II/c)">Pengatur (II/c)</option>
                                    <option value="Staff Tata Usaha">Staff Tata Usaha</option>
                                    <option value="PPNPN">PPNPN (Honorer)</option>
                                </select>
                                @error('pangkat_golongan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jabatan Struktural/Fungsional <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="jabatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Contoh: Kasi Intelijen">
                                @error('jabatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <hr class="border-gray-200 my-2">

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email Login <span class="text-red-500">*</span></label>
                                <input type="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" wire:model="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="{{ $is_edit ? 'Kosongkan jika password tetap' : 'Min. 6 Karakter' }}">
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        <span wire:loading.remove wire:target="store">Simpan Data</span>
                        <span wire:loading wire:target="store">Menyimpan...</span>
                    </button>
                    <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>