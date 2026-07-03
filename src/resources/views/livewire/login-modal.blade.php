<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component
{
    public LoginForm $form;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $redirectTo = '';

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $redirectUrl = $this->redirectTo ?: request()->header('Referer') ?: url('/');
        if (str_contains($redirectUrl, '/login') || str_contains($redirectUrl, '/register')) {
            $redirectUrl = url('/');
        }

        $this->redirect($redirectUrl);
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.\App\Models\User::class],
            'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);

        event(new \Illuminate\Auth\Events\Registered($user = \App\Models\User::create($validated)));

        \Illuminate\Support\Facades\Auth::login($user);

        Session::regenerate();

        $redirectUrl = $this->redirectTo ?: request()->header('Referer') ?: url('/');
        if (str_contains($redirectUrl, '/login') || str_contains($redirectUrl, '/register')) {
            $redirectUrl = url('/');
        }

        $this->redirect($redirectUrl);
    }
}; ?>

<div
    x-data="{ open: false, mode: 'login' }"
    x-on:open-login-modal.window="open = true; mode = 'login'; $wire.redirectTo = $event.detail?.redirectTo || ''"
    x-on:open-register-modal.window="open = true; mode = 'register'; $wire.redirectTo = $event.detail?.redirectTo || ''"
    x-on:close-login-modal.window="open = false"
    x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
    style="display: none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <!-- Backdrop with glassmorphic blur -->
    <div 
        class="fixed inset-0 bg-slate-900/60 dark:bg-black/70 backdrop-blur-md transition-opacity"
        x-on:click="open = false"
    ></div>

    <!-- Modal Content Card -->
    <div
        class="relative w-full max-w-md transform overflow-hidden rounded-3xl bg-white/95 dark:bg-gray-900/95 border border-gray-200 dark:border-white/10 p-8 shadow-2xl transition-all"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <!-- Close Button -->
        <button 
            type="button"
            x-on:click="open = false"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <div class="text-center mb-6">
            <h3 x-show="mode === 'login'" class="text-2xl font-bold text-gray-900 dark:text-white bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                Login Hans Padel
            </h3>
            <h3 x-show="mode === 'register'" class="text-2xl font-bold text-gray-900 dark:text-white bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent" style="display: none;">
                Daftar Hans Padel
            </h3>
            <p x-show="mode === 'login'" class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                Silakan login terlebih dahulu untuk melanjutkan pemesanan
            </p>
            <p x-show="mode === 'register'" class="text-sm text-gray-600 dark:text-gray-300 mt-2" style="display: none;">
                Silakan isi data berikut untuk mendaftar akun baru
            </p>
        </div>

        <!-- Login Form -->
        <form x-show="mode === 'login'" wire:submit="login" class="space-y-4">
            <!-- Email Address -->
            <div>
                <label for="modal-email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
                <input 
                    wire:model="form.email" 
                    id="modal-email" 
                    type="email" 
                    required 
                    autofocus 
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="nama@email.com"
                >
                <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="modal-password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Password</label>
                <input 
                    wire:model="form.password" 
                    id="modal-password" 
                    type="password" 
                    required 
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="••••••••"
                >
                <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input wire:model="form.remember" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500 bg-white/50 dark:bg-gray-800/50">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">Ingat saya</span>
                </label>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold p-3 rounded-lg hover:from-blue-700 hover:to-cyan-600 transition shadow-lg shadow-blue-500/20 active:scale-95">
                    Log In
                </button>
            </div>

            <!-- Register Info -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-300 mt-4">
                Belum punya akun? 
                <button type="button" x-on:click="mode = 'register'" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <!-- Register Form -->
        <form x-show="mode === 'register'" wire:submit="register" class="space-y-4" style="display: none;">
            <!-- Name -->
            <div>
                <label for="register-name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Lengkap</label>
                <input 
                    wire:model="name" 
                    id="register-name" 
                    type="text" 
                    required 
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="Nama Lengkap Anda"
                >
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="register-email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
                <input 
                    wire:model="email" 
                    id="register-email" 
                    type="email" 
                    required 
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="nama@email.com"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="register-password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Password</label>
                <input 
                    wire:model="password" 
                    id="register-password" 
                    type="password" 
                    required 
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="••••••••"
                >
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="register-password-confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Konfirmasi Password</label>
                <input 
                    wire:model="password_confirmation" 
                    id="register-password-confirmation" 
                    type="password" 
                    required 
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="••••••••"
                >
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold p-3 rounded-lg hover:from-blue-700 hover:to-cyan-600 transition shadow-lg shadow-blue-500/20 active:scale-95">
                    Daftar Akun
                </button>
            </div>

            <!-- Login Info -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-300 mt-4">
                Sudah punya akun? 
                <button type="button" x-on:click="mode = 'login'" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                    Log In
                </button>
            </div>
        </form>
    </div>
</div>
