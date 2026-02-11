<?php

namespace App\Livewire\Lapinhar;

use App\Models\Lapinhar;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class LapinharIndex extends Component
{
    use WithPagination;

    // Data Input Form
    public $nomor_surat, $tanggal_surat, $sumber_informasi, $bidang;
    public $peristiwa, $pendapat, $status = 'rahasia', $status_verifikasi = 'pending';
    public $lapinhar_id;

    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    // Filter Pencarian
    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'sumber_informasi' => 'required|string',
            'bidang' => 'required|string', // Ipoleksosbudhankam
            'peristiwa' => 'required|string|min:10',
            'pendapat' => 'required|string|min:5',
            'status' => 'required|in:rahasia,biasa',
        ];
    }

    public function render()
    {
        $data = Lapinhar::where('peristiwa', 'like', '%' . $this->search . '%')
            ->orWhere('nomor_surat', 'like', '%' . $this->search . '%')
            ->orWhere('bidang', 'like', '%' . $this->search . '%')
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10);

        return view('livewire.lapinhar.lapinhar-index', [
            'lapinhars' => $data
        ]);
    }

    public function create()
    {
        $this->reset(); // Bersihkan form
        $this->tanggal_surat = date('Y-m-d'); // Default hari ini
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        Lapinhar::updateOrCreate(['id' => $this->lapinhar_id], [
            'user_id' => Auth::id(), // Otomatis catat siapa yang input
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'sumber_informasi' => $this->sumber_informasi,
            'bidang' => $this->bidang,
            'peristiwa' => $this->peristiwa,
            'pendapat' => $this->pendapat,
            'status' => $this->status,
            // Jika edit, status verifikasi jangan di-reset. Jika baru, set pending.
            'status_verifikasi' => $this->is_edit ? $this->status_verifikasi : 'pending',
        ]);

        $this->showModal = false;
        session()->flash('message', $this->is_edit ? 'Laporan diperbarui.' : 'Laporan berhasil dibuat.');
        $this->reset();
    }

    public function edit($id)
    {
        $data = Lapinhar::findOrFail($id);
        $this->lapinhar_id = $id;
        $this->nomor_surat = $data->nomor_surat;
        $this->tanggal_surat = $data->tanggal_surat->format('Y-m-d');
        $this->sumber_informasi = $data->sumber_informasi;
        $this->bidang = $data->bidang;
        $this->peristiwa = $data->peristiwa;
        $this->pendapat = $data->pendapat;
        $this->status = $data->status;
        $this->status_verifikasi = $data->status_verifikasi;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        Lapinhar::findOrFail($id)->delete();
        session()->flash('message', 'Laporan berhasil dihapus.');
    }

    // Fitur Quick Approve (Hanya untuk Kasi/Admin - Opsional nanti)
    public function approve($id)
    {
        $data = Lapinhar::findOrFail($id);
        $data->update(['status_verifikasi' => 'disetujui']);
        session()->flash('message', 'Laporan disetujui.');
    }
}
