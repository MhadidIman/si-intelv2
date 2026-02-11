<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Jaksa Masuk Sekolah (JMS)</h2>
                <p class="text-sm text-gray-500">Program Pembinaan Masyarakat Taat Hukum (Binmatkum).</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reports.jms') }}" target="_blank" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>
                <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Input Kegiatan
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow rounded-r">{{ session('message') }}</div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow mb-6 border border-gray-100">
            <input wire:model.live="search" type="text" placeholder="Cari nama sekolah atau materi..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Sekolah</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Materi & Narasumber</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Verifikasi</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jms as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_sekolah }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">{{ Str::limit($item->materi, 40) }}</div>
                                <div class="text-xs text-gray-500 italic">Peserta: {{ $item->jumlah_peserta }} Siswa</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->status_verifikasi == 'pending')
                                <span class="px-2 py-1 text-[10px] font-bold bg-yellow-100 text-yellow-800 rounded border border-yellow-200 uppercase">Pending</span>
                                @elseif($item->status_verifikasi == 'disetujui')
                                <span class="px-2 py-1 text-[10px] font-bold bg-green-100 text-green-800 rounded border border-green-200 uppercase">Disetujui</span>
                                @else
                                <span class="px-2 py-1 text-[10px] font-bold bg-red-100 text-red-800 rounded border border-red-200 uppercase">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->foto_kegiatan)
                                <img class="h-10 w-10 rounded shadow-sm object-cover mx-auto border" src="{{ asset('storage/' . $item->foto_kegiatan) }}">
                                @else
                                <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('reports.jms.satuan', $item->id) }}" target="_blank" class="text-gray-500 hover:text-gray-900 mr-4" title="Cetak Laporan">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                                <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3 font-bold">Edit</button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data?" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic font-medium">Belum ada data kegiatan JMS.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">{{ $jms->links() }}</div>
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
                        {{ $is_edit ? 'Update Laporan JMS' : 'Input Laporan JMS Baru' }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                                <input type="text" wire:model="nama_sekolah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                @error('nama_sekolah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                    <input type="date" wire:model="tanggal_kegiatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Siswa</label>
                                    <input type="number" wire:model="jumlah_peserta" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Keterangan / Hasil</label>
                                <textarea wire:model="keterangan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"></textarea>
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <label class="block text-sm font-bold text-yellow-800 mb-2">Verifikasi Admin</label>
                                <div class="flex gap-4">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" wire:model="status_verifikasi" value="pending" class="text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-xs font-bold text-yellow-700">PENDING</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" wire:model="status_verifikasi" value="disetujui" class="text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-xs font-bold text-green-700">SETUJUI</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" wire:model="status_verifikasi" value="ditolak" class="text-red-600 focus:ring-red-500">
                                        <span class="ml-2 text-xs font-bold text-red-700">TOLAK</span>
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Materi Penyuluhan</label>
                                <input type="text" wire:model="materi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Narasumber</label>
                                <input type="text" wire:model="narasumber" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                            </div>
                            <div class="border rounded-lg p-3 bg-gray-50 border-dashed border-gray-300">
                                <label class="block text-xs font-bold text-gray-700 mb-2 italic">Dokumentasi Foto</label>
                                <div class="flex items-center space-x-4">
                                    @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="h-16 w-16 object-cover rounded border-2 border-purple-500 shadow-sm">
                                    @elseif ($old_foto)
                                    <img src="{{ asset('storage/' . $old_foto) }}" class="h-16 w-16 object-cover rounded border border-gray-300 shadow-sm">
                                    @endif
                                    <input type="file" wire:model="foto" class="text-xs">
                                </div>
                                <div wire:loading wire:target="foto" class="text-xs text-blue-600 mt-2 font-bold animate-pulse">Sedang mengupload foto...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        <span wire:loading.remove wire:target="store">Simpan Perubahan</span>
                        <span wire:loading wire:target="store">Memproses...</span>
                    </button>
                    <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>