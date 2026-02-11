<?php

namespace App\Livewire\Wna;

use App\Models\Wna;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class WnaIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Data Input
    public $nama_lengkap, $tempat_lahir, $tanggal_lahir, $negara_asal, $nomor_paspor;
    public $tujuan_kunjungan, $sponsor, $tempat_tinggal, $masa_berlaku_izin;
    public $status_verifikasi = 'pending';

    // Upload Foto
    public $foto;
    public $old_foto;

    public $wna_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'negara_asal' => 'required|string',
            'nomor_paspor' => 'required|string',
            'tujuan_kunjungan' => 'required|string',
            'sponsor' => 'nullable|string',
            'tempat_tinggal' => 'required|string',
            'masa_berlaku_izin' => 'required|date',
            'foto' => 'nullable|image|max:2048', // Max 2MB
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ];
    }

    public function render()
    {
        $query = Wna::query();

        if ($this->search) {
            $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                ->orWhere('negara_asal', 'like', '%' . $this->search . '%')
                ->orWhere('nomor_paspor', 'like', '%' . $this->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.wna.wna-index', ['wnas' => $data]);
    }

    public function create()
    {
        $this->reset([
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'negara_asal',
            'nomor_paspor',
            'tujuan_kunjungan',
            'sponsor',
            'tempat_tinggal',
            'masa_berlaku_izin',
            'foto',
            'old_foto',
            'wna_id'
        ]);
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = Wna::findOrFail($id);

        $this->wna_id = $id;
        $this->nama_lengkap = $data->nama_lengkap;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->tanggal_lahir = $data->tanggal_lahir ? $data->tanggal_lahir->format('Y-m-d') : null;
        $this->negara_asal = $data->negara_asal;
        $this->nomor_paspor = $data->nomor_paspor;
        $this->tujuan_kunjungan = $data->tujuan_kunjungan;
        $this->sponsor = $data->sponsor;
        $this->tempat_tinggal = $data->tempat_tinggal;
        $this->masa_berlaku_izin = $data->masa_berlaku_izin ? $data->masa_berlaku_izin->format('Y-m-d') : null;
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
            'negara_asal' => $this->negara_asal,
            'nomor_paspor' => $this->nomor_paspor,
            'tujuan_kunjungan' => $this->tujuan_kunjungan,
            'sponsor' => $this->sponsor,
            'tempat_tinggal' => $this->tempat_tinggal,
            'masa_berlaku_izin' => $this->masa_berlaku_izin,
        ];

        // Logic Verifikasi (Admin vs Staff)
        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        // Logic Upload Foto
        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $dataToSave['foto'] = $this->foto->store('fotos-wna', 'public');
        }

        if ($this->is_edit) {
            $wna = Wna::findOrFail($this->wna_id);
            $wna->update($dataToSave);
            session()->flash('message', 'Data WNA berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id();
            Wna::create($dataToSave);
            session()->flash('message', 'Data WNA baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['foto', 'old_foto', 'wna_id']);
    }

    public function delete($id)
    {
        $data = Wna::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak memiliki izin menghapus data ini.');
            return;
        }

        if ($data->foto) {
            Storage::disk('public')->delete($data->foto);
        }

        $data->delete();
        session()->flash('message', 'Data WNA berhasil dihapus.');
    }
}
