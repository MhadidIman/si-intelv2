<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <div class="flex flex-col items-center justify-center mb-6">
        <img src="{{ asset('img/logo-kejaksaan.png') }}" class="w-24 h-24 mb-4 drop-shadow-sm" alt="Logo Kejaksaan">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">SI-INTEL V2</h2>
        <p class="text-sm text-gray-500">Sistem Informasi Intelijen Kejaksaan</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <div>
            <x-input-label for="nip" :value="__('NIP (Nomor Induk Pegawai)')" />
            <x-text-input
                wire:model="form.nip"
                id="nip"
                class="block mt-1 w-full border-gray-300 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                type="text"
                inputmode="numeric"
                pattern="[0-9]*"
                maxlength="18"
                name="nip"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan 18 digit NIP" />
            <x-input-error :messages="$errors->get('form.nip')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input
                wire:model="form.password"
                id="password"
                class="block mt-1 w-full border-gray-300 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-green-700 shadow-sm focus:ring-green-600" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-500 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition" href="{{ route('password.request') }}" wire:navigate>
                {{ __('Lupa Kata Sandi?') }}
            </a>
            @endif

            <x-primary-button class="ms-3 bg-green-700 hover:bg-green-800 focus:bg-green-800 active:bg-green-900 transition ease-in-out duration-150">
                {{ __('Masuk Sistem') }}
            </x-primary-button>
        </div>
    </form>
</div>