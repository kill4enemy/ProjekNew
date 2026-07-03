<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Setting::getValue('business_name', 'Hans Padel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-slate-50 text-gray-900 flex flex-col min-h-screen">
    @include('components.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-400 py-10 mt-auto border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm">
                {{ \App\Models\Setting::getValue('business_footer', '© 2026 Hans Padel. Semua Hak Dilindungi Undang-Undang.') }}
            </p>
        </div>
    </footer>

    <livewire:auth.login-modal />

    @livewireScripts
</body>
</html>