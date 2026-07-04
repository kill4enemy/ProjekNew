<nav class="sticky top-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur border-b border-gray-200 dark:border-white/10">
    <div class="flex items-center justify-between px-8 py-4">
        <a href="/" class="text-xl font-bold text-gray-900 dark:text-white hover:opacity-85 transition">
            Hans Padel
        </a>

        <div class="flex items-center gap-6">
            <a href="/" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                Home
            </a>

            <a href="/#about" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                About
            </a>

            <a href="/courts" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                Courts
            </a>

            <a href="/booking" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                Booking
            </a>

            @auth
                @if(auth()->user()->hasRole('super_admin'))
                    <a href="/admin" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                        Admin Panel
                    </a>
                @endif

                <a href="/riwayat-transaksi" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                    Transaction
                </a>

                <a href="/profile" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition">
                    Profile ({{ auth()->user()->name }})
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600 dark:hover:text-red-400 font-medium transition">
                        Log Out
                    </button>
                </form>
            @else
                <button
                    onclick="window.dispatchEvent(new CustomEvent('open-login-modal'))"
                    class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition"
                >
                    Login
                </button>
                <button
                    onclick="window.dispatchEvent(new CustomEvent('open-register-modal'))"
                    class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300 font-medium transition"
                >
                    Register
                </button>
            @endauth

            <button
                id="theme-toggle"
                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-white/30 text-gray-900 dark:text-white bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
                🌙
            </button>
        </div>
    </div>
</nav>