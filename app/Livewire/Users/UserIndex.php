<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // 1. Import Fitur Upload
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class UserIndex extends Component
{
    use WithPagination, WithFileUploads; // 2. Gunakan Fitur Upload

    // Data Input
    public $name, $email, $password, $user_id;
    public $nip, $nrp, $pangkat_golongan, $jabatan, $no_hp;

    // Upload Foto
    public $foto;          // Variabel penampung file upload baru
    public $old_foto;      // Variabel untuk menyimpan path foto lama (saat edit)

    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => $this->is_edit ? 'nullable|min:6' : 'required|min:6',
            'nip' => 'nullable|numeric|digits:18',
            'nrp' => 'nullable|string',
            'pangkat_golongan' => 'required|string',
            'jabatan' => 'required|string',
            'no_hp' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048', // Maksimal 2MB
        ];
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('nip', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.users.user-index', ['users' => $users]);
    }

    public function create()
    {
        $this->reset(); // Reset semua input termasuk foto
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'nip' => $this->nip,
            'nrp' => $this->nrp,
            'pangkat_golongan' => $this->pangkat_golongan,
            'jabatan' => $this->jabatan,
            'no_hp' => $this->no_hp,
            'satuan_kerja' => 'Kejaksaan Negeri',
        ];

        // LOGIKA UPLOAD FOTO
        if ($this->foto) {
            // Jika edit dan ada foto lama, hapus dulu file lamanya
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            // Simpan foto baru
            $data['foto_profil'] = $this->foto->store('fotos-personil', 'public');
        }

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->user_id], $data);

        $this->showModal = false;
        $this->reset('foto'); // Bersihkan file upload dari memori
        session()->flash('message', $this->is_edit ? 'Data berhasil diperbarui.' : 'Personil berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nip = $user->nip;
        $this->nrp = $user->nrp;
        $this->pangkat_golongan = $user->pangkat_golongan;
        $this->jabatan = $user->jabatan;
        $this->no_hp = $user->no_hp;

        $this->old_foto = $user->foto_profil; // Simpan path foto lama untuk preview
        $this->foto = null; // Reset input file baru

        $this->password = '';
        $this->is_edit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        $user->delete();
        session()->flash('message', 'Pegawai berhasil dihapus.');
    }
}
