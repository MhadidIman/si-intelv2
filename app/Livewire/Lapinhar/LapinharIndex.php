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
    public $peristiwa, $pendapat, $status = 'rahasia';
    public $status_verifikasi = 'pending'; // Default

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
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ];
    }

    public function render()
    {
        $query = Lapinhar::query();

        if ($this->search) {
            $query->where('peristiwa', 'like', '%' . $this->search . '%')
                ->orWhere('nomor_surat', 'like', '%' . $this->search . '%')
                ->orWhere('bidang', 'like', '%' . $this->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.lapinhar.lapinhar-index', [
            'lapinhars' => $data
        ]);
    }

    public function create()
    {
        $this->reset(['nomor_surat', 'sumber_informasi', 'bidang', 'peristiwa', 'pendapat', 'lapinhar_id']);
        $this->tanggal_surat = date('Y-m-d');
        $this->status = 'rahasia';
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = Lapinhar::findOrFail($id);

        $this->lapinhar_id = $id;
        $this->nomor_surat = $data->nomor_surat;
        $this->tanggal_surat = $data->tanggal_surat->format('Y-m-d'); // Pastikan format date string
        $this->sumber_informasi = $data->sumber_informasi;
        $this->bidang = $data->bidang;
        $this->peristiwa = $data->peristiwa;
        $this->pendapat = $data->pendapat;
        $this->status = $data->status;
        $this->status_verifikasi = $data->status_verifikasi;

        $this->is_edit = true;
        $this->showModal = true;
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

        // Logika Status Verifikasi
        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            // Staff: Input baru -> Pending, Edit -> Tetap status lama
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        if ($this->is_edit) {
            $lapinhar = Lapinhar::findOrFail($this->lapinhar_id);
            $lapinhar->update($dataToSave);
            session()->flash('message', 'Laporan berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id(); // Set pemilik data
            Lapinhar::create($dataToSave);
            session()->flash('message', 'Laporan berhasil dibuat.');
        }

        $this->showModal = false;
        $this->reset(['nomor_surat', 'sumber_informasi', 'peristiwa', 'pendapat', 'lapinhar_id']);
    }

    public function delete($id)
    {
        $data = Lapinhar::findOrFail($id);

        // Proteksi Hapus: Hanya Admin atau Pemilik Data
        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak berhak menghapus data ini.');
            return;
        }

        $data->delete();
        session()->flash('message', 'Laporan berhasil dihapus.');
    }
}
