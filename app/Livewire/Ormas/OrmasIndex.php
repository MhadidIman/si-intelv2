<?php

namespace App\Livewire\Ormas;

use App\Models\Ormas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class OrmasIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Properti Form
    public $nama_organisasi, $nama_pimpinan, $alamat_sekretariat;
    public $bentuk_organisasi, $status_legalitas, $nomor_sk, $kegiatan_utama;
    public $jumlah_anggota, $afiliasi, $status_pengawasan = 'aktif';

    // Properti Foto
    public $foto;      // Untuk menampung file baru
    public $old_foto;  // Untuk menampung path foto lama saat edit

    public $ormas_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    // Aturan Validasi
    protected function rules()
    {
        return [
            'nama_organisasi' => 'required|string|max:255',
            'nama_pimpinan' => 'required|string|max:255',
            'alamat_sekretariat' => 'required|string',
            'bentuk_organisasi' => 'required|string',
            'status_legalitas' => 'required|string',
            'nomor_sk' => 'nullable|string',
            'kegiatan_utama' => 'required|string',
            'jumlah_anggota' => 'nullable|integer',
            'afiliasi' => 'nullable|string',
            'status_pengawasan' => 'required|in:aktif,waspada,dibekukan',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function render()
    {
        $data = Ormas::where('nama_organisasi', 'like', '%' . $this->search . '%')
            ->orWhere('nama_pimpinan', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.ormas.ormas-index', ['ormas' => $data]);
    }

    public function create()
    {
        $this->reset(['nama_organisasi', 'nama_pimpinan', 'alamat_sekretariat', 'bentuk_organisasi', 'status_legalitas', 'nomor_sk', 'kegiatan_utama', 'jumlah_anggota', 'afiliasi', 'foto', 'ormas_id']);
        $this->status_pengawasan = 'aktif';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(), // Mengisi user_id dari petugas yang login
            'nama_organisasi' => $this->nama_organisasi,
            'nama_pimpinan' => $this->nama_pimpinan,
            'alamat_sekretariat' => $this->alamat_sekretariat,
            'bentuk_organisasi' => $this->bentuk_organisasi,
            'status_legalitas' => $this->status_legalitas,
            'nomor_sk' => $this->nomor_sk,
            'kegiatan_utama' => $this->kegiatan_utama,
            'jumlah_anggota' => $this->jumlah_anggota ?? 0,
            'afiliasi' => $this->afiliasi,
            'status_pengawasan' => $this->status_pengawasan,
        ];

        // Logika Upload Lambang/Logo
        if ($this->foto) {
            // Jika sedang edit dan ada foto lama, hapus dari storage
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            // Simpan foto baru
            $data['foto_lambang'] = $this->foto->store('fotos-ormas', 'public');
        }

        // Simpan atau Update ke Database
        Ormas::updateOrCreate(['id' => $this->ormas_id], $data);

        $this->showModal = false;
        $this->reset(['foto', 'old_foto']);

        session()->flash('message', $this->is_edit ? 'Data Ormas diperbarui.' : 'Ormas baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Ormas::findOrFail($id);
        $this->ormas_id = $id;
        $this->nama_organisasi = $data->nama_organisasi;
        $this->nama_pimpinan = $data->nama_pimpinan;
        $this->alamat_sekretariat = $data->alamat_sekretariat;
        $this->bentuk_organisasi = $data->bentuk_organisasi;
        $this->status_legalitas = $data->status_legalitas;
        $this->nomor_sk = $data->nomor_sk;
        $this->kegiatan_utama = $data->kegiatan_utama;
        $this->jumlah_anggota = $data->jumlah_anggota;
        $this->afiliasi = $data->afiliasi;
        $this->status_pengawasan = $data->status_pengawasan;

        $this->old_foto = $data->foto_lambang; // Simpan path lama untuk preview
        $this->foto = null; // Reset input file baru

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $data = Ormas::findOrFail($id);

        // Hapus file lambang dari storage jika ada
        if ($data->foto_lambang) {
            Storage::disk('public')->delete($data->foto_lambang);
        }

        $data->delete();
        session()->flash('message', 'Data Ormas berhasil dihapus.');
    }
}
