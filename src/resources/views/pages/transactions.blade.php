@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">
                Riwayat Transaksi
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">
                Pantau status pembayaran dan kelola pemesanan lapangan Anda.
            </p>
        </div>
        <a href="/booking" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Booking Baru
        </a>
    </div>

    @if($bookings->isEmpty())
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-2xl p-12 text-center border border-gray-100 dark:border-gray-700/50 shadow-xl">
            <div class="w-20 h-20 bg-indigo-50 dark:bg-indigo-950/50 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-500 dark:text-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Transaksi</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">
                Anda belum melakukan pemesanan lapangan apa pun. Mulai booking lapangan padel favorit Anda sekarang juga!
            </p>
            <a href="/booking" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-300">
                Booking Lapangan Sekarang
            </a>
        </div>
    @else
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/30">
                            <th class="p-5 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kode Booking</th>
                            <th class="p-5 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lapangan</th>
                            <th class="p-5 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jadwal</th>
                            <th class="p-5 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Harga</th>
                            <th class="p-5 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="p-5 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/10 transition-colors duration-200">
                                <td class="p-5">
                                    <div class="font-semibold text-gray-900 dark:text-white">
                                        {{ $booking->booking_code }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                        Dibuat: {{ $booking->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $booking->court->name ?? 'Lapangan' }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $booking->court->type ?? '' }}
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="text-gray-700 dark:text-gray-300 font-medium">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($booking->total_price) }}
                                    </div>
                                </td>
                                <td class="p-5">
                                    @if($booking->status === 'confirmed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-900/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Berhasil
                                        </span>
                                    @elseif($booking->status === 'pending_payment')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400 border border-amber-200/50 dark:border-amber-900/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu Pembayaran
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400 border border-rose-200/50 dark:border-rose-900/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 text-right">
                                    @if($booking->status === 'pending_payment')
                                        <a href="{{ route('payment.show', $booking) }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-4 py-2 rounded-xl transition duration-200 shadow-md shadow-blue-500/20">
                                            Bayar Sekarang
                                        </a>
                                    @elseif($booking->status === 'confirmed')
                                        <a href="{{ route('invoice.show', $booking) }}" class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold text-sm px-4 py-2 rounded-xl transition duration-200">
                                            Invoice
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="p-5 border-t border-gray-100 dark:border-gray-700/50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
