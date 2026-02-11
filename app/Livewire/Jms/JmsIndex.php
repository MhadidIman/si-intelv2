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

    // Gunakan satu tempat validasi agar konsisten
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
        ];
    }

    public function render()
    {
        $data = JmsActivity::where('nama_sekolah', 'like', '%' . $this->search . '%')
            ->orWhere('materi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.jms.jms-index', ['jms' => $data]);
    }

    public function create()
    {
        $this->reset(['nama_sekolah', 'tanggal_kegiatan', 'materi', 'jumlah_peserta', 'narasumber', 'keterangan', 'foto', 'jms_id']);
        $this->tanggal_kegiatan = date('Y-m-d');
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function store()
    {
        // Jalankan validasi dari fungsi rules()
        $this->validate();

        $data = [
            'user_id' => Auth::id(), // Mengambil ID petugas yang login
            'nama_sekolah' => $this->nama_sekolah,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'materi' => $this->materi,
            'jumlah_peserta' => $this->jumlah_peserta,
            'narasumber' => $this->narasumber,
            'keterangan' => $this->keterangan,
            'status_verifikasi' => $this->status_verifikasi,
        ];

        // Penanganan Foto
        if ($this->foto) {
            // Jika sedang edit dan ganti foto, hapus foto yang lama di storage
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            // Simpan foto baru ke folder 'fotos-jms'
            $data['foto_kegiatan'] = $this->foto->store('fotos-jms', 'public');
        }

        // Simpan data (Create jika jms_id null, Update jika ada)
        JmsActivity::updateOrCreate(['id' => $this->jms_id], $data);

        $this->showModal = false;
        $this->reset(['foto', 'old_foto', 'jms_id']);

        session()->flash('message', $this->is_edit ? 'Kegiatan JMS berhasil diperbarui.' : 'Kegiatan JMS berhasil ditambahkan.');
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
        $this->keterangan = $data->keterangan; // Tambahkan ini agar tidak error lagi
        $this->status_verifikasi = $data->status_verifikasi;

        $this->old_foto = $data->foto_kegiatan;
        $this->foto = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $data = JmsActivity::findOrFail($id);

        // Hapus file foto dari storage sebelum hapus record di DB
        if ($data->foto_kegiatan) {
            Storage::disk('public')->delete($data->foto_kegiatan);
        }

        $data->delete();
        session()->flash('message', 'Data kegiatan JMS berhasil dihapus.');
    }

    // Tambahkan fungsi ini di dalam Class JmsIndex atau PamSdoIndex
    public function verify($id, $status)
    {
        // Hanya Admin yang boleh eksekusi
        if (auth()->user()->role !== 'admin') {
            session()->flash('error', 'Anda tidak memiliki akses.');
            return;
        }

        $data = \App\Models\JmsActivity::findOrFail($id); // Sesuaikan Modelnya
        $data->update(['status_verifikasi' => $status]);

        session()->flash('message', 'Status verifikasi berhasil diperbarui menjadi ' . $status);
    }
}
