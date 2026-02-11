<?php

namespace App\Livewire\Dpo;

use App\Models\Dpo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // WAJIB: Untuk upload foto
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

    // Upload Foto
    public $foto;      // Penampung file baru
    public $old_foto;  // Penampung path foto lama (saat edit)

    public $dpo_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'kasus' => 'required|string',
            'status_hukum' => 'required|string', // Tersangka / Terpidana
            'ciri_fisik' => 'nullable|string',
            'status_pencarian' => 'required|in:buron,tertangkap',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function render()
    {
        $data = Dpo::where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('kasus', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.dpo.dpo-index', ['dpos' => $data]);
    }

    public function create()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'kasus' => $this->kasus,
            'status_hukum' => $this->status_hukum,
            'ciri_fisik' => $this->ciri_fisik,
            'status_pencarian' => $this->status_pencarian,
            'status_verifikasi' => 'pending', // Default pending
        ];

        // LOGIKA UPLOAD FOTO
        if ($this->foto) {
            // Hapus foto lama jika ada (saat edit)
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            // Simpan foto baru
            $data['foto'] = $this->foto->store('fotos-dpo', 'public');
        }

        Dpo::updateOrCreate(['id' => $this->dpo_id], $data);

        $this->showModal = false;
        $this->reset('foto'); // Bersihkan file dari memori
        session()->flash('message', $this->is_edit ? 'Data DPO diperbarui.' : 'Buronan baru ditambahkan.');
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

        $this->old_foto = $data->foto; // Simpan path lama
        $this->foto = null; // Reset input baru

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $data = Dpo::findOrFail($id);
        // Hapus file foto fisik
        if ($data->foto) {
            Storage::disk('public')->delete($data->foto);
        }
        $data->delete();
        session()->flash('message', 'Data DPO berhasil dihapus.');
    }
}
