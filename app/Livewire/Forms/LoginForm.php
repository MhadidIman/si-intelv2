<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    // Menggunakan NIP sebagai pengenal login
    // size:18 memastikan panjang karakter harus tepat 18 (tidak kurang/lebih)
    #[Validate('required|string|size:18')]
    public string $nip = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Menangani upaya autentikasi menggunakan NIP.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Proses Login: Cek kecocokan NIP dan Password di database
        if (! Auth::attempt(['nip' => $this->nip, 'password' => $this->password], $this->remember)) {
            // Jika gagal, catat percobaan gagal di RateLimiter
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.nip' => 'NIP atau Password yang Anda masukkan tidak valid.',
            ]);
        }

        // Jika berhasil, bersihkan catatan RateLimiter
        RateLimiter::clear($this->throttleKey());

        // Logika Tambahan: Pesan Selamat Datang Berdasarkan Role
        $user = Auth::user();

        if ($user->role === 'admin') {
            session()->flash('message', 'Selamat Datang Kembali, Komandan! Sistem Siap Digunakan.');
        } else {
            session()->flash('message', 'Selamat Datang, Petugas. Selamat Bertugas!');
        }
    }

    /**
     * Memastikan permintaan autentikasi tidak dibatasi (rate limited) akibat spam login.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.nip' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Mendapatkan kunci pembatas (throttle key) unik berdasarkan NIP dan IP Address.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->nip) . '|' . request()->ip());
    }
}
