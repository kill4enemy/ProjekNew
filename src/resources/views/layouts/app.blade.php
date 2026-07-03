<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Padel Court Booking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class'
        }
        window.isAuthenticated = @json(\Illuminate\Support\Facades\Auth::check());
    </script>
</head>

<script type="module">
    import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';

    mermaid.initialize({
        startOnLoad: true,
        theme: 'default',
    });
</script>

<body class="scroll-smooth bg-gray-100 dark:bg-gray-900 dark:text-white transition-colors">

    {{-- Navbar --}}
    @include('components.navbar')

    <main class="w-full px-4 sm:px-6 lg:px-10">
        @if (isset($header))
            <header class="py-6 border-b border-gray-200 dark:border-white/10 mb-6">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <script>
        const html = document.documentElement;

        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        }

        document
            .getElementById('theme-toggle')
            ?.addEventListener('click', () => {

                html.classList.toggle('dark');

                localStorage.setItem(
                    'theme',
                    html.classList.contains('dark')
                        ? 'dark'
                        : 'light'
                );
            });
    </script>

<footer class="mt-16 border-t border-gray-200 dark:border-white/10 bg-slate-100 dark:bg-gradient-to-r dark:from-slate-950 dark:to-blue-950 text-gray-700 dark:text-gray-300">
    <div class="w-full px-4 sm:px-6 lg:px-10 py-12">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Hans Padel
                </h3>

                <p class="text-gray-400 leading-relaxed">
                    Sistem Informasi Penyewaan Lapangan Padel berbasis web
                    untuk memudahkan pengguna melakukan booking lapangan secara online.
                </p>
            </div>

            {{-- Menu --}}
            <div>
                <h4 class="text-gray-900 dark:text-white font-semibold mb-4">
                    Menu
                </h4>

                <ul class="space-y-2">
                    <li><a href="/#about" class="hover:text-blue-400">About</a></li>
                    <li><a href="/courts" class="hover:text-blue-400">Courts</a></li>
                    <li><a href="/booking" class="hover:text-blue-400">Booking</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-gray-900 dark:text-white font-semibold mb-4">
                    Contact
                </h4>

                <ul class="space-y-4">

                    {{-- WhatsApp --}}
                    <li>
                        <a
                            href="https://wa.me/6281284216264"
                            target="_blank"
                            class="flex items-center gap-3 hover:text-green-500 transition"
                        >
                         <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M12.04 2C6.52 2 2.04 6.48 2.04 12c0 1.77.46 3.5 1.34 5.03L2 22l5.11-1.34A9.94 9.94 0 0 0 12.04 22c5.52 0 10-4.48 10-10s-4.48-10-10-10zm5.78 14.41c-.24.67-1.38 1.28-1.9 1.36-.49.07-1.1.11-1.78-.11-.41-.13-.93-.3-1.61-.59-2.83-1.22-4.67-4.08-4.81-4.27-.14-.19-1.15-1.53-1.15-2.91 0-1.39.73-2.07.99-2.36.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.48.24.58.81 1.99.88 2.14.07.14.12.31.02.5-.09.19-.14.31-.28.47-.14.16-.29.35-.41.47-.14.14-.29.29-.13.56.16.27.72 1.19 1.54 1.93 1.06.95 1.95 1.25 2.22 1.39.28.14.44.12.6-.07.17-.19.72-.84.91-1.13.19-.29.38-.24.64-.14.26.09 1.66.79 1.94.93.29.14.48.21.55.33.07.12.07.71-.17 1.38z"/>
                        </svg>
                            <span>Whatsapp</span>
                        </a>
                    </li>

                    {{-- Email --}}
                    <li>
                        <a
                            href="mailto:raihanisad2007@gmail.com"
                            class="flex items-center gap-3 hover:text-blue-500 transition"
                        >
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5H4.5A2.25 2.25 0 0 0 2.25 6.75m19.5 0-8.69 5.52a2.25 2.25 0 0 1-2.42 0L2.25 6.75"/>
                        </svg>
                            <span>Email</span>
                        </a>
                    </li>

                    {{-- Instagram --}}
                    <li>
                        <a
                            href="https://www.instagram.com/kil4.er"
                            target="_blank"
                            class="flex items-center gap-3 hover:text-pink-500 transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24" class="w-5 h-5">
                                <path d="M7.75 2C4.57 2 2 4.57 2 7.75v8.5C2 19.43 4.57 22 7.75 22h8.5C19.43 22 22 19.43 22 16.25v-8.5C22 4.57 19.43 2 16.25 2h-8.5zm0 1.8h8.5a3.95 3.95 0 0 1 3.95 3.95v8.5a3.95 3.95 0 0 1-3.95 3.95h-8.5A3.95 3.95 0 0 1 3.8 16.25v-8.5A3.95 3.95 0 0 1 7.75 3.8zm8.85 1.3a1.1 1.1 0 1 0 0 2.2 1.1 1.1 0 0 0 0-2.2zM12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 1.8A3.2 3.2 0 1 1 8.8 12 3.2 3.2 0 0 1 12 8.8z"/>
                            </svg>
                            <span>Instagram</span>
                        </a>
                    </li>

                    {{-- Discord --}}
                    <li>
                        <a
                            href="https://discord.gg/rceNzeezWD"
                            target="_blank"
                            class="flex items-center gap-3 hover:text-indigo-500 transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24" class="w-5 h-5">
                                <path d="M20.32 4.37A19.79 19.79 0 0 0 15.4 3l-.24.49a18.27 18.27 0 0 1 4.39 1.34c-2.76-1.29-5.76-1.93-8.79-1.87-2.94-.04-5.86.59-8.54 1.85A18.2 18.2 0 0 1 6.84 3l-.24-.49A19.68 19.68 0 0 0 1.68 4.37C-1.34 8.88-.71 13.28.04 17.56A19.95 19.95 0 0 0 5.98 20l1.28-1.71c-.7-.27-1.37-.61-2-.99l.48-.36c3.86 1.8 8.08 1.8 11.9 0l.48.36c-.63.38-1.3.72-2 .99L18.4 20a19.9 19.9 0 0 0 5.92-2.44c.88-4.95.14-9.31-4-13.19z"/>
                            </svg>
                            <span>Discord</span>
                        </a>
                    </li>

                </ul>
            </div>
                <div>
            <h4 class="text-gray-900 dark:text-white font-semibold mb-4">
                Jam Operasional
            </h4>

            <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                <li>Senin - Jumat: 08.00 - 22.00</li>
                <li>Sabtu - Minggu: 07.00 - 23.00</li>
            </ul>
        </div>

        </div>

        <div class="mt-10 pt-6 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-900 dark:text-white font-semibold mb-4">
                © {{ date('Y') }} Hans Padel. All rights reserved.
            </p>

            <div class="flex gap-6 text-sm">
                <span>Pemrograman Web</span>
                <span>Laravel 12</span>
                <span>Filament v3</span>
            </div>
        </div>

    </div>
</footer>

<livewire:login-modal />

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.isAuthenticated) {
            document.body.addEventListener('click', (e) => {
                const target = e.target.closest('a[href="/booking"], button.booking-btn, form[action*="booking"] button[type="submit"], form[action*="booking"] button:not([type])');
                if (target) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.dispatchEvent(new CustomEvent('open-login-modal', { detail: { redirectTo: '/booking' } }));
                }
            });
        }
    });
</script>
</body>
</html>