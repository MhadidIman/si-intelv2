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

    // Data Input
    public $nama_organisasi, $nama_pimpinan, $alamat_sekretariat;
    public $bentuk_organisasi, $status_legalitas, $nomor_sk;
    public $kegiatan_utama, $jumlah_anggota, $afiliasi;
    public $status_pengawasan = 'aktif';
    public $status_verifikasi = 'pending';

    // Upload Foto Lambang
    public $foto_lambang;
    public $old_foto;

    public $ormas_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'nama_organisasi' => 'required|string|max:255',
            'nama_pimpinan' => 'required|string|max:255',
            'alamat_sekretariat' => 'required|string',
            'bentuk_organisasi' => 'required|string', // Ormas/LSM/Yayasan
            'status_legalitas' => 'required|string',
            'nomor_sk' => 'nullable|string',
            'kegiatan_utama' => 'required|string',
            'jumlah_anggota' => 'nullable|integer',
            'afiliasi' => 'nullable|string',
            'status_pengawasan' => 'required|in:aktif,waspada,dibekukan',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
            'foto_lambang' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function render()
    {
        $query = Ormas::query();

        if ($this->search) {
            $query->where('nama_organisasi', 'like', '%' . $this->search . '%')
                ->orWhere('nama_pimpinan', 'like', '%' . $this->search . '%')
                ->orWhere('bentuk_organisasi', 'like', '%' . $this->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.ormas.ormas-index', ['ormas' => $data]);
    }

    public function create()
    {
        $this->reset([
            'nama_organisasi',
            'nama_pimpinan',
            'alamat_sekretariat',
            'bentuk_organisasi',
            'status_legalitas',
            'nomor_sk',
            'kegiatan_utama',
            'jumlah_anggota',
            'afiliasi',
            'foto_lambang',
            'old_foto',
            'ormas_id'
        ]);

        $this->status_pengawasan = 'aktif';
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
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
        $this->status_verifikasi = $data->status_verifikasi;

        $this->old_foto = $data->foto_lambang;
        $this->foto_lambang = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nama_organisasi' => $this->nama_organisasi,
            'nama_pimpinan' => $this->nama_pimpinan,
            'alamat_sekretariat' => $this->alamat_sekretariat,
            'bentuk_organisasi' => $this->bentuk_organisasi,
            'status_legalitas' => $this->status_legalitas,
            'nomor_sk' => $this->nomor_sk,
            'kegiatan_utama' => $this->kegiatan_utama,
            'jumlah_anggota' => $this->jumlah_anggota,
            'afiliasi' => $this->afiliasi,
            'status_pengawasan' => $this->status_pengawasan,
        ];

        // Logic Verifikasi (Admin vs Staff)
        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        // Logic Upload Foto Lambang
        if ($this->foto_lambang) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $dataToSave['foto_lambang'] = $this->foto_lambang->store('fotos-ormas', 'public');
        }

        if ($this->is_edit) {
            $ormas = Ormas::findOrFail($this->ormas_id);
            $ormas->update($dataToSave);
            session()->flash('message', 'Data Ormas berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id();
            Ormas::create($dataToSave);
            session()->flash('message', 'Data Ormas baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['foto_lambang', 'old_foto', 'ormas_id']);
    }

    public function delete($id)
    {
        $data = Ormas::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak memiliki izin menghapus data ini.');
            return;
        }

        if ($data->foto_lambang) {
            Storage::disk('public')->delete($data->foto_lambang);
        }

        $data->delete();
        session()->flash('message', 'Data Ormas berhasil dihapus.');
    }
}
