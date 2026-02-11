<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pengawasan Ormas / LSM</h2>
                <p class="text-sm text-gray-500">Data organisasi kemasyarakatan dan status legalitas.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reports.ormas') }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>
                <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Input Ormas Baru
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow rounded-r">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow rounded-r">{{ session('error') }}</div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow mb-6 border border-gray-100">
            <input wire:model.live="search" type="text" placeholder="Cari nama ormas, pimpinan, atau bentuk organisasi..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Logo</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas Organisasi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Legalitas & Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Verifikasi</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ormas as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->foto_lambang)
                                <img class="h-12 w-12 rounded object-cover border border-gray-300 shadow-sm mx-auto" src="{{ asset('storage/' . $item->foto_lambang) }}">
                                @else
                                <span class="text-xs text-gray-400">No Logo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_organisasi }}</div>
                                <div class="text-xs text-gray-500">Ketua: {{ $item->nama_pimpinan }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 border border-gray-300 mt-1">
                                    {{ $item->bentuk_organisasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">{{ $item->status_legalitas }}</div>
                                <div class="text-xs text-gray-500">SK: {{ $item->nomor_sk ?? '-' }}</div>
                                <div class="mt-1">
                                    @if($item->status_pengawasan == 'aktif')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-green-100 text-green-800 rounded">AKTIF</span>
                                    @elseif($item->status_pengawasan == 'waspada')
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-yellow-100 text-yellow-800 rounded">WASPADA</span>
                                    @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-red-100 text-red-800 rounded">DIBEKUKAN</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->status_verifikasi == 'disetujui')
                                <span class="px-2 py-1 text-[10px] font-bold bg-green-100 text-green-800 rounded border border-green-200 uppercase">Disetujui</span>
                                @elseif($item->status_verifikasi == 'ditolak')
                                <span class="px-2 py-1 text-[10px] font-bold bg-red-100 text-red-800 rounded border border-red-200 uppercase">Ditolak</span>
                                @else
                                <span class="px-2 py-1 text-[10px] font-bold bg-yellow-100 text-yellow-800 rounded border border-yellow-200 uppercase">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('reports.ormas.satuan', $item->id) }}" target="_blank" class="text-gray-500 hover:text-gray-900 mr-3" title="Cetak Data">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>

                                @if(auth()->user()->role === 'admin')
                                <button wire:click="edit({{ $item->id }})" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs font-bold shadow-sm transition mr-2">
                                    VERIFIKASI
                                </button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data Ormas ini?" class="text-red-600 hover:text-red-900 font-bold text-xs">Hapus</button>
                                @elseif(auth()->id() === $item->user_id)
                                <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs mr-2">Edit</button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data Ormas ini?" class="text-red-600 hover:text-red-900 font-bold text-xs">Hapus</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic font-medium">Belum ada data Ormas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">{{ $ormas->links() }}</div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showModal', false)"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">
                        {{ $is_edit ? 'Update Data Ormas' : 'Input Data Ormas Baru' }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                                <input type="text" wire:model="nama_organisasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('nama_organisasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pimpinan / Ketua</label>
                                <input type="text" wire:model="nama_pimpinan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('nama_pimpinan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Sekretariat</label>
                                <textarea wire:model="alamat_sekretariat" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Bentuk Org.</label>
                                    <select wire:model="bentuk_organisasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">-- Pilih --</option>
                                        <option value="Ormas">Ormas</option>
                                        <option value="LSM">LSM</option>
                                        <option value="Yayasan">Yayasan</option>
                                        <option value="Perkumpulan">Perkumpulan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Anggota</label>
                                    <input type="number" wire:model="jumlah_anggota" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200 shadow-inner">
                                <label class="block text-sm font-bold text-yellow-800 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Verifikasi Pimpinan
                                </label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center cursor-pointer bg-white px-3 py-1 rounded border hover:bg-gray-50">
                                        <input type="radio" wire:model="status_verifikasi" value="pending" class="text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-xs font-bold text-yellow-700 uppercase">Pending</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer bg-white px-3 py-1 rounded border hover:bg-gray-50">
                                        <input type="radio" wire:model="status_verifikasi" value="disetujui" class="text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-xs font-bold text-green-700 uppercase">Setujui</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer bg-white px-3 py-1 rounded border hover:bg-gray-50">
                                        <input type="radio" wire:model="status_verifikasi" value="ditolak" class="text-red-600 focus:ring-red-500">
                                        <span class="ml-2 text-xs font-bold text-red-700 uppercase">Tolak</span>
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Legalitas</label>
                                <input type="text" wire:model="status_legalitas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" placeholder="Contoh: Berbadan Hukum / Terdaftar">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor SK / AHU</label>
                                <input type="text" wire:model="nomor_sk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" placeholder="Nomor Surat Keputusan...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kegiatan Utama</label>
                                <input type="text" wire:model="kegiatan_utama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" placeholder="Sosial, Keagamaan, Politik...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Pengawasan</label>
                                <select wire:model="status_pengawasan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="aktif">Aktif</option>
                                    <option value="waspada">Waspada (Perlu Pantauan)</option>
                                    <option value="dibekukan">Dibekukan / Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="border rounded-lg p-3 bg-gray-50 border-dashed border-gray-300">
                                <label class="block text-xs font-bold text-gray-700 mb-2 italic">Logo / Lambang Ormas</label>
                                <div class="flex items-center space-x-4">
                                    @if ($foto_lambang)
                                    <img src="{{ $foto_lambang->temporaryUrl() }}" class="h-16 w-16 object-cover rounded border-2 border-indigo-500 shadow-sm">
                                    @elseif ($old_foto)
                                    <img src="{{ asset('storage/' . $old_foto) }}" class="h-16 w-16 object-cover rounded border border-gray-300 shadow-sm">
                                    @endif
                                    <input type="file" wire:model="foto_lambang" class="text-xs">
                                </div>
                                <div wire:loading wire:target="foto_lambang" class="text-xs text-blue-600 mt-2 font-bold animate-pulse">Sedang mengupload logo...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 transition">
                        <span wire:loading.remove wire:target="store">Simpan Data</span>
                        <span wire:loading wire:target="store">Memproses...</span>
                    </button>
                    <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>