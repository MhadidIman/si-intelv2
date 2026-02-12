<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    /**
     * Kredensial menggunakan NIP (Nomor Induk Pegawai) 
     * sesuai standar operasional Kejaksaan.
     */
    #[Validate('required|string')]
    public string $nip = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Melakukan autentikasi ke dalam sistem terminal SI-INTEL V2.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Mencoba mencocokkan NIP dan Password di database
        if (! Auth::attempt($this->only(['nip', 'password']), $this->remember)) {

            // LOG AKTIFITAS: Mencatat percobaan login yang gagal untuk audit keamanan
            User::logActivity('GAGAL LOGIN', 'Percobaan akses terminal menggunakan NIP: ' . $this->nip);

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.nip' => trans('auth.failed'),
            ]);
        }

        // LOG AKTIFITAS: Mencatat keberhasilan otentikasi ke dalam sistem
        User::logActivity('LOGIN', 'Personil berhasil melakukan otentikasi ke terminal utama');

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Memastikan permintaan autentikasi tidak melampaui batas (Rate Limiting).
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        // LOG AKTIFITAS: Mencatat pemblokiran akses sementara karena brute force
        User::logActivity('SISTEM TERKUNCI', 'Akses diblokir sementara karena terlalu banyak percobaan login pada NIP: ' . $this->nip);

        throw ValidationException::withMessages([
            'form.nip' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Mendapatkan kunci pembatas (throttle key) berdasarkan NIP dan IP Address.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->nip) . '|' . request()->ip());
    }
}
