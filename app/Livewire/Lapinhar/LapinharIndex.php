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

    // --- PROPERTI UTAMA (Wajib Public agar terbaca di View) ---
    public $showModal = false; // Ini variabel yang bikin error tadi
    public $is_edit = false;
    public $search = '';
    public $lapinhar_id;

    // Data Form
    public $nomor_surat;
    public $tanggal_surat;
    public $sumber_informasi;
    public $bidang;
    public $peristiwa;
    public $pendapat;
    public $status = 'rahasia';
    public $status_verifikasi = 'pending';

    // Reset halaman saat searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'sumber_informasi' => 'required|string',
            'bidang' => 'required|string',
            'peristiwa' => 'required|string|min:10',
            'pendapat' => 'required|string|min:5',
            'status' => 'required|in:rahasia,biasa',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ];
    }

    public function render()
    {
        $query = Lapinhar::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('peristiwa', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang', 'like', '%' . $this->search . '%');
            });
        }

        // Urutkan dari yang terbaru
        $lapinhars = $query->latest()->paginate(10);

        return view('livewire.lapinhar.lapinhar-index', [
            'lapinhars' => $lapinhars
        ]);
    }

    public function create()
    {
        $this->resetInput();
        $this->tanggal_surat = date('Y-m-d');
        $this->is_edit = false;
        $this->showModal = true; // Buka Modal
    }

    public function edit($id)
    {
        $data = Lapinhar::findOrFail($id);

        $this->lapinhar_id = $id;
        $this->nomor_surat = $data->nomor_surat;
        // Pastikan format tanggal string untuk input date HTML
        $this->tanggal_surat = \Carbon\Carbon::parse($data->tanggal_surat)->format('Y-m-d');
        $this->sumber_informasi = $data->sumber_informasi;
        $this->bidang = $data->bidang;
        $this->peristiwa = $data->peristiwa;
        $this->pendapat = $data->pendapat;
        $this->status = $data->status;
        $this->status_verifikasi = $data->status_verifikasi;

        $this->is_edit = true;
        $this->showModal = true; // Buka Modal
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'sumber_informasi' => $this->sumber_informasi,
            'bidang' => $this->bidang,
            'peristiwa' => $this->peristiwa,
            'pendapat' => $this->pendapat,
            'status' => $this->status,
        ];

        // Logika Verifikasi: Hanya Admin yang bisa ubah status lewat form ini
        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        }

        if ($this->is_edit) {
            $lapinhar = Lapinhar::findOrFail($this->lapinhar_id);
            $lapinhar->update($dataToSave);

            // Log Aktivitas (Opsional jika sudah ada Model User::logActivity)
            // \App\Models\User::logActivity('UPDATE LAPINHAR', 'Nomor: ' . $this->nomor_surat);

            session()->flash('message', 'Laporan berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id();
            $dataToSave['status_verifikasi'] = 'pending'; // Default baru selalu pending

            Lapinhar::create($dataToSave);

            // \App\Models\User::logActivity('CREATE LAPINHAR', 'Nomor: ' . $this->nomor_surat);

            session()->flash('message', 'Laporan berhasil dibuat.');
        }

        $this->showModal = false; // Tutup Modal
        $this->resetInput();
    }

    public function delete($id)
    {
        $data = Lapinhar::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('message', 'Anda tidak berhak menghapus data ini.');
            return;
        }

        $data->delete();
        session()->flash('message', 'Laporan berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetInput()
    {
        $this->reset([
            'nomor_surat',
            'sumber_informasi',
            'bidang',
            'peristiwa',
            'pendapat',
            'lapinhar_id'
        ]);
        $this->status = 'rahasia';
        $this->status_verifikasi = 'pending';
    }
}
