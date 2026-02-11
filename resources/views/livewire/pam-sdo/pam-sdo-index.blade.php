<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">PAM SDO (Pengamanan Sumber Daya Organisasi)</h2>
                <p class="text-sm text-gray-500">Giat Pengamanan Personil, Materiil, dan Proyek Strategis.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reports.pam-sdo') }}" target="_blank" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Input Giat PAM
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow rounded-r">{{ session('message') }}</div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <input wire:model.live="search" type="text" placeholder="Cari kegiatan atau lokasi..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kegiatan PAM</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelaksana & Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Verifikasi</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pams as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $item->lokasi }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_kegiatan }}</div>
                                <div class="text-xs text-gray-500 uppercase font-medium text-blue-600">{{ $item->kategori_pam }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->pelaksana }}</div>
                                @if($item->status == 'Aman')
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-green-100 text-green-800 border border-green-200">AMAN</span>
                                @else
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-red-100 text-red-800 border border-red-200 uppercase">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->status_verifikasi == 'pending')
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 uppercase">Pending</span>
                                @elseif($item->status_verifikasi == 'disetujui')
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 border border-green-200 uppercase">Disetujui</span>
                                @else
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200 uppercase">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('reports.pam-sdo.satuan', $item->id) }}" target="_blank" class="text-gray-500 hover:text-gray-900 mr-3" title="Cetak Laporan">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>

                                <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada kegiatan PAM.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">{{ $pams->links() }}</div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">
                        {{ $is_edit ? 'Edit Giat PAM' : 'Input Giat PAM Baru' }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                                <input type="text" wire:model="nama_kegiatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('nama_kegiatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori PAM</label>
                                <select wire:model="kategori_pam" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="Pengamanan Personil">Pengamanan Personil</option>
                                    <option value="Pengamanan Materiil">Pengamanan Materiil / Aset</option>
                                    <option value="Pengamanan Kegiatan">Pengamanan Kegiatan / Acara</option>
                                    <option value="Pengamanan Informasi">Pengamanan Informasi</option>
                                </select>
                                @error('kategori_pam') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                    <input type="date" wire:model="tanggal_kegiatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Keamanan</label>
                                    <select wire:model="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                        <option value="Aman">Aman & Kondusif</option>
                                        <option value="Ada Ancaman">Ada Ancaman / Gangguan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lokasi Kegiatan</label>
                                <input type="text" wire:model="lokasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                @error('lokasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Petugas Pelaksana</label>
                                <input type="text" wire:model="pelaksana" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                @error('pelaksana') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Keterangan / Hasil</label>
                                <textarea wire:model="keterangan" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"></textarea>
                            </div>

                            <div class="border p-2 rounded bg-gray-50">
                                <label class="block text-xs font-bold text-gray-700 mb-1">Dokumentasi Foto</label>
                                <div class="flex items-center space-x-2">
                                    @if($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="h-10 w-10 rounded border">
                                    @elseif($old_foto)
                                    <img src="{{ asset('storage/' . $old_foto) }}" class="h-10 w-10 rounded border">
                                    @endif
                                    <input type="file" wire:model="foto" class="text-xs">
                                </div>
                                <div wire:loading wire:target="foto" class="text-xs text-blue-500">Mengupload...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        <span wire:loading.remove wire:target="store">Simpan Laporan</span>
                        <span wire:loading wire:target="store">Memproses...</span>
                    </button>
                    <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>