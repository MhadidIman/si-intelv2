<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class UserIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Data Input
    public $user_id;
    public $name, $email, $password;
    public $nip, $nrp, $pangkat_golongan, $jabatan, $no_hp;
    public $role = 'staff'; // Default role staff

    // Upload Foto
    public $foto;
    public $old_foto;

    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    // Pesan Validasi Custom (Bahasa Indonesia)
    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.unique' => 'Email ini sudah terdaftar.',
        'password.required' => 'Password wajib diisi untuk akun baru.',
        'password.min' => 'Password minimal 6 karakter.',
        'nip.digits' => 'NIP harus berjumlah 18 digit angka.',
        'role.required' => 'Role akses harus dipilih.',
        'jabatan.required' => 'Jabatan wajib diisi.',
        'pangkat_golongan.required' => 'Pangkat/Golongan wajib dipilih.',
    ];

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
            'role' => 'required|in:admin,staff,user', // Validasi Role
            'no_hp' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('nip', 'like', '%' . $this->search . '%')
                ->orWhere('jabatan', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(10);

        return view('livewire.users.user-index', ['users' => $users]);
    }

    public function create()
    {
        $this->reset();
        $this->role = 'staff'; // Reset default role
        $this->is_edit = false;
        $this->showModal = true;
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
        $this->role = $user->role; // Load Role yang ada

        $this->old_foto = $user->foto_profil;
        $this->foto = null;
        $this->password = '';

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        // Validasi Otomatis (Jika gagal, akan stop dan kirim error ke view)
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'nip' => $this->nip,
            'nrp' => $this->nrp,
            'pangkat_golongan' => $this->pangkat_golongan,
            'jabatan' => $this->jabatan,
            'role' => $this->role, // SIMPAN ROLE DISINI
            'no_hp' => $this->no_hp,
            'satuan_kerja' => 'Kejaksaan Negeri Sanggau',
        ];

        // Logika Foto
        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $data['foto_profil'] = $this->foto->store('fotos-personil', 'public');
        }

        // Logika Password
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        // Simpan Data
        User::updateOrCreate(['id' => $this->user_id], $data);

        // Pencatatan Log Aktivitas (Opsional)
        if (class_exists(\App\Models\User::class) && method_exists(\App\Models\User::class, 'logActivity')) {
            $action = $this->is_edit ? 'UPDATE PERSONIL' : 'TAMBAH PERSONIL';
            \App\Models\User::logActivity($action, 'Mengelola data personil: ' . $this->name . ' (' . strtoupper($this->role) . ')');
        }

        $this->showModal = false;
        $this->reset('foto');
        session()->flash('message', $this->is_edit ? 'Data personil berhasil diperbarui.' : 'Personil baru berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();
        session()->flash('message', 'Data personil berhasil dihapus.');
    }
}
