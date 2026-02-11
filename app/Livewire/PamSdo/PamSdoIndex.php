<?php

namespace App\Livewire\PamSdo;

use App\Models\PamSdo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class PamSdoIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $nama_kegiatan, $kategori_pam, $tanggal_kegiatan;
    public $lokasi, $pelaksana, $keterangan, $status = 'Aman';
    public $status_verifikasi = 'pending'; // Tambahkan ini

    public $foto;
    public $old_foto;

    public $pam_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'nama_kegiatan' => 'required|string',
            'kategori_pam' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'lokasi' => 'required|string',
            'pelaksana' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
            'status_verifikasi' => 'required|string', // Tambahkan validasi
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function render()
    {
        $data = PamSdo::where('nama_kegiatan', 'like', '%' . $this->search . '%')
            ->orWhere('lokasi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.pam-sdo.pam-sdo-index', ['pams' => $data]);
    }

    public function create()
    {
        $this->reset(['nama_kegiatan', 'kategori_pam', 'lokasi', 'pelaksana', 'keterangan', 'foto', 'pam_id']);
        $this->tanggal_kegiatan = date('Y-m-d');
        $this->status = 'Aman';
        $this->status_verifikasi = 'pending'; // Default saat buat baru
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(), // Pastikan user_id terisi
            'nama_kegiatan' => $this->nama_kegiatan,
            'kategori_pam' => $this->kategori_pam,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'lokasi' => $this->lokasi,
            'pelaksana' => $this->pelaksana,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
            'status_verifikasi' => $this->status_verifikasi, // Kirim status_verifikasi ke DB
        ];

        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $data['foto_dokumentasi'] = $this->foto->store('fotos-pam', 'public');
        }

        PamSdo::updateOrCreate(['id' => $this->pam_id], $data);

        $this->showModal = false;
        $this->reset(['foto', 'old_foto']);
        session()->flash('message', $this->is_edit ? 'Laporan PAM SDO diperbarui.' : 'Laporan PAM SDO berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = PamSdo::findOrFail($id);
        $this->pam_id = $id;
        $this->nama_kegiatan = $data->nama_kegiatan;
        $this->kategori_pam = $data->kategori_pam;
        $this->tanggal_kegiatan = $data->tanggal_kegiatan;
        $this->lokasi = $data->lokasi;
        $this->pelaksana = $data->pelaksana;
        $this->keterangan = $data->keterangan;
        $this->status = $data->status;
        $this->status_verifikasi = $data->status_verifikasi; // Ambil data verifikasi dari DB

        $this->old_foto = $data->foto_dokumentasi;
        $this->foto = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $data = PamSdo::findOrFail($id);
        if ($data->foto_dokumentasi) Storage::disk('public')->delete($data->foto_dokumentasi);
        $data->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }
}
