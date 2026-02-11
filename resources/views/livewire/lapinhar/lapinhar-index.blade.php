<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Laporan Informasi Harian (LAPINHAR)</h2>
                <p class="text-sm text-gray-500">Rekapitulasi peristiwa dan analisa intelijen harian.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('reports.lapinhar') }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Laporan Baru
                </button>
            </div>
        </div>

        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow rounded-r">
            {{ session('message') }}
        </div>
        @endif
        @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow rounded-r">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow mb-6 border border-gray-100">
            <input wire:model.live="search" type="text" placeholder="Cari berdasarkan Nomor Surat, Peristiwa, atau Bidang..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & No. Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bidang</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Isi Peristiwa</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Verifikasi</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($lapinhars as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $item->tanggal_surat->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $item->nomor_surat }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 uppercase">
                                    {{ $item->bidang }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 line-clamp-2">{{ \Illuminate\Support\Str::limit($item->peristiwa, 80) }}</div>
                                <div class="text-xs text-gray-500 mt-1">Sumber: {{ $item->sumber_informasi }}</div>
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
                                <a href="{{ route('reports.lapinhar.satuan', $item->id) }}" target="_blank" class="text-gray-500 hover:text-gray-900 mr-3" title="Cetak PDF">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>

                                @if(auth()->user()->role === 'admin')
                                <button wire:click="edit({{ $item->id }})" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs font-bold shadow-sm transition mr-2">
                                    VERIFIKASI
                                </button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin hapus laporan ini?" class="text-red-600 hover:text-red-900 font-bold text-xs">Hapus</button>
                                @elseif(auth()->id() === $item->user_id)
                                <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs mr-2">Edit</button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin hapus laporan ini?" class="text-red-600 hover:text-red-900 font-bold text-xs">Hapus</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic font-medium">
                                Belum ada Laporan Informasi Harian.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $lapinhars->links() }}
            </div>
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
                        {{ $is_edit ? 'Edit Laporan Informasi' : 'Buat Laporan Informasi Baru' }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                                <input type="text" wire:model="nomor_surat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="R-XXX/O.3.10/Dek.1/MM/YYYY">
                                @error('nomor_surat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                                <input type="date" wire:model="tanggal_surat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bidang Intelijen</label>
                                <select wire:model="bidang" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Pilih Bidang --</option>
                                    <option value="Ideologi">Ideologi</option>
                                    <option value="Politik">Politik</option>
                                    <option value="Ekonomi">Ekonomi</option>
                                    <option value="Sosial Budaya">Sosial Budaya</option>
                                    <option value="Pertahanan Keamanan">Pertahanan & Keamanan</option>
                                </select>
                                @error('bidang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sumber Informasi</label>
                                <input type="text" wire:model="sumber_informasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Contoh: Masyarakat, Penyelidikan Terbuka">
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
                                <label class="block text-sm font-medium text-gray-700">Peristiwa / Fakta-Fakta</label>
                                <textarea wire:model="peristiwa" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Uraikan peristiwa secara detail..."></textarea>
                                @error('peristiwa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pendapat / Analisa Intelijen</label>
                                <textarea wire:model="pendapat" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Analisa potensi ancaman dan saran tindak lanjut..."></textarea>
                                @error('pendapat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sifat Laporan</label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="status" value="rahasia" class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Rahasia</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="status" value="biasa" class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Biasa</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" wire:click="store" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Simpan Laporan
                    </button>
                    <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>