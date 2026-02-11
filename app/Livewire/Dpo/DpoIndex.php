<?php

namespace App\Livewire\Dpo;

use App\Models\Dpo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class DpoIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Data Input
    public $nama_lengkap, $tempat_lahir, $tanggal_lahir, $kasus;
    public $status_hukum, $ciri_fisik, $status_pencarian = 'buron';
    public $status_verifikasi = 'pending'; // Default status

    // Upload Foto
    public $foto;      // Penampung file baru
    public $old_foto;  // Penampung path foto lama

    public $dpo_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'kasus' => 'required|string',
            'status_hukum' => 'required|string',
            'ciri_fisik' => 'nullable|string',
            'status_pencarian' => 'required|in:buron,tertangkap',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function render()
    {
        $query = Dpo::query();

        if ($this->search) {
            $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                ->orWhere('kasus', 'like', '%' . $this->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.dpo.dpo-index', ['dpos' => $data]);
    }

    public function create()
    {
        $this->reset(['nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'kasus', 'status_hukum', 'ciri_fisik', 'foto', 'old_foto', 'dpo_id']);
        $this->status_pencarian = 'buron';
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = Dpo::findOrFail($id);

        $this->dpo_id = $id;
        $this->nama_lengkap = $data->nama_lengkap;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->tanggal_lahir = $data->tanggal_lahir ? $data->tanggal_lahir->format('Y-m-d') : null;
        $this->kasus = $data->kasus;
        $this->status_hukum = $data->status_hukum;
        $this->ciri_fisik = $data->ciri_fisik;
        $this->status_pencarian = $data->status_pencarian;
        $this->status_verifikasi = $data->status_verifikasi;

        $this->old_foto = $data->foto;
        $this->foto = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'kasus' => $this->kasus,
            'status_hukum' => $this->status_hukum,
            'ciri_fisik' => $this->ciri_fisik,
            'status_pencarian' => $this->status_pencarian,
        ];

        // Logika Status Verifikasi
        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            // Staff input baru -> Pending
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        // Handle Foto
        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $dataToSave['foto'] = $this->foto->store('fotos-dpo', 'public');
        }

        if ($this->is_edit) {
            $dpo = Dpo::findOrFail($this->dpo_id);
            $dpo->update($dataToSave);
            session()->flash('message', 'Data DPO berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id(); // Set pemilik data
            Dpo::create($dataToSave);
            session()->flash('message', 'Buronan baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['foto', 'old_foto', 'dpo_id']);
    }

    public function delete($id)
    {
        $data = Dpo::findOrFail($id);

        // Proteksi Hapus: Hanya Admin atau Pemilik Data
        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak memiliki izin menghapus data ini.');
            return;
        }

        if ($data->foto) {
            Storage::disk('public')->delete($data->foto);
        }

        $data->delete();
        session()->flash('message', 'Data DPO berhasil dihapus.');
    }
}
