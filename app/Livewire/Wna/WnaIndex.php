<?php

namespace App\Livewire\Wna;

use App\Models\Wna;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class WnaIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Data Input
    public $nama_lengkap, $tempat_lahir, $tanggal_lahir;
    public $negara_asal, $nomor_paspor, $tujuan_kunjungan;
    public $sponsor, $tempat_tinggal, $masa_berlaku_izin;

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
            'nama_lengkap' => 'required|string',
            'negara_asal' => 'required|string',
            'nomor_paspor' => 'required|string',
            'tujuan_kunjungan' => 'required|string',
            'tempat_tinggal' => 'required|string',
            'masa_berlaku_izin' => 'required|date',
            'sponsor' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function render()
    {
        $data = Wna::where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('negara_asal', 'like', '%' . $this->search . '%')
            ->orWhere('nomor_paspor', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.wna.wna-index', ['wnas' => $data]);
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
            'user_id'           => auth()->id(),
            'nama_lengkap'      => $this->nama_lengkap,
            'tempat_lahir'      => $this->tempat_lahir,
            'tanggal_lahir'     => $this->tanggal_lahir,
            'negara_asal'       => $this->negara_asal,       // <--- PASTIKAN INI ADA
            'nomor_paspor'      => $this->nomor_paspor,
            'tujuan_kunjungan'  => $this->tujuan_kunjungan,
            'sponsor'           => $this->sponsor,
            'tempat_tinggal'    => $this->tempat_tinggal,    // <--- PASTIKAN INI ADA
            'masa_berlaku_izin' => $this->masa_berlaku_izin,
        ];

        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->old_foto);
            }
            $data['foto'] = $this->foto->store('fotos-wna', 'public');
        }

        \App\Models\Wna::updateOrCreate(['id' => $this->wna_id], $data);

        $this->showModal = false;
        $this->reset(['foto', 'nama_lengkap', 'negara_asal', 'nomor_paspor', 'tujuan_kunjungan']); // Reset secukupnya
        session()->flash('message', 'Data WNA berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = Wna::findOrFail($id);
        $this->wna_id = $id;
        $this->nama_lengkap = $data->nama_lengkap;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->tanggal_lahir = $data->tanggal_lahir;
        $this->negara_asal = $data->negara_asal;
        $this->nomor_paspor = $data->nomor_paspor;
        $this->tujuan_kunjungan = $data->tujuan_kunjungan;
        $this->sponsor = $data->sponsor;
        $this->tempat_tinggal = $data->tempat_tinggal;
        $this->masa_berlaku_izin = $data->masa_berlaku_izin;

        $this->old_foto = $data->foto;
        $this->foto = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $data = Wna::findOrFail($id);
        if ($data->foto) Storage::disk('public')->delete($data->foto);
        $data->delete();
        session()->flash('message', 'Data WNA dihapus.');
    }
}
