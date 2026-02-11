<?php

namespace App\Livewire\Jms;

use App\Models\JmsActivity;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class JmsIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Properti Form
    public $nama_sekolah, $tanggal_kegiatan, $materi;
    public $jumlah_peserta, $narasumber, $keterangan;
    public $status_verifikasi = 'pending';

    // Properti File/Foto
    public $foto;      // Untuk upload baru
    public $old_foto;  // Untuk preview foto lama

    // State Management
    public $jms_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    // Rules Validasi
    protected function rules()
    {
        return [
            'nama_sekolah' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'materi' => 'required|string',
            'jumlah_peserta' => 'required|integer|min:1',
            'narasumber' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048', // Max 2MB
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ];
    }

    public function render()
    {
        $query = JmsActivity::query();

        // Fitur Pencarian
        if ($this->search) {
            $query->where('nama_sekolah', 'like', '%' . $this->search . '%')
                ->orWhere('materi', 'like', '%' . $this->search . '%');
        }

        // Urutkan dari yang terbaru
        $data = $query->latest()->paginate(10);

        return view('livewire.jms.jms-index', ['jms' => $data]);
    }

    public function create()
    {
        $this->reset(['nama_sekolah', 'tanggal_kegiatan', 'materi', 'jumlah_peserta', 'narasumber', 'keterangan', 'foto', 'old_foto', 'jms_id']);

        $this->tanggal_kegiatan = date('Y-m-d');
        $this->status_verifikasi = 'pending'; // Default status
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = JmsActivity::findOrFail($id);

        $this->jms_id = $id;
        $this->nama_sekolah = $data->nama_sekolah;
        $this->tanggal_kegiatan = $data->tanggal_kegiatan;
        $this->materi = $data->materi;
        $this->jumlah_peserta = $data->jumlah_peserta;
        $this->narasumber = $data->narasumber;
        $this->keterangan = $data->keterangan;
        $this->status_verifikasi = $data->status_verifikasi;

        $this->old_foto = $data->foto_kegiatan;
        $this->foto = null; // Reset input file baru

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        // Data dasar yang akan disimpan
        $dataToSave = [
            'nama_sekolah' => $this->nama_sekolah,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'materi' => $this->materi,
            'jumlah_peserta' => $this->jumlah_peserta,
            'narasumber' => $this->narasumber,
            'keterangan' => $this->keterangan,
        ];

        // Logika Status Verifikasi
        if (Auth::user()->role === 'admin') {
            // Admin bebas menentukan status
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            // Staff input baru -> Pending
            // Staff edit data lama -> Status tidak berubah (tetap seperti di DB)
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        // Penanganan Upload Foto
        if ($this->foto) {
            // Hapus foto lama jika ada (saat edit)
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            // Simpan foto baru
            $dataToSave['foto_kegiatan'] = $this->foto->store('fotos-jms', 'public');
        }

        // Eksekusi Simpan ke Database
        if ($this->is_edit) {
            $jms = JmsActivity::findOrFail($this->jms_id);
            $jms->update($dataToSave);
            session()->flash('message', 'Data kegiatan JMS berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id(); // Assign pemilik data
            JmsActivity::create($dataToSave);
            session()->flash('message', 'Kegiatan JMS baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['foto', 'old_foto', 'jms_id']);
    }

    public function delete($id)
    {
        $data = JmsActivity::findOrFail($id);

        // Hanya Admin atau Pemilik Data yang boleh menghapus
        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak memiliki izin menghapus data ini.');
            return;
        }

        if ($data->foto_kegiatan) {
            Storage::disk('public')->delete($data->foto_kegiatan);
        }

        $data->delete();
        session()->flash('message', 'Data kegiatan JMS berhasil dihapus.');
    }
}
