@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">
    Daftar Lapangan
</h2>

<form method="GET" action="/courts" class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
    <label class="block mb-2 text-gray-900 dark:text-white">
        Cek Ketersediaan Berdasarkan Tanggal
    </label>

    <div class="flex gap-3">
        <input
            type="date"
            name="date"
            value="{{ $selectedDate }}"
            class="border p-3 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
        >

        <button class="bg-blue-600 text-white px-5 py-2 rounded">
            Cek
        </button>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($courts as $court)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

            @if($court->image)
                <img
                    src="{{ str_starts_with($court->image, 'images/')
                        ? asset($court->image)
                        : asset('storage/' . $court->image) }}"
                    class="w-full h-48 object-cover"
                >
            @else
                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300">
                    Belum ada gambar
                </div>
            @endif

            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $court->name }}
                </h3>

            <p class="text-gray-600 dark:text-gray-300">
                Tipe: {{ $court->type }} | Kapasitas: {{ $court->capacity }} Orang
            </p>

            @if($court->description)
                <div class="mt-3 mb-4">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Fasilitas:
                    </p>

                    <div class="space-y-1">
                        @foreach(explode("\n", $court->description) as $facility)
                            @if(trim($facility) !== '')
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $facility }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <p class="text-gray-700 dark:text-gray-200 mb-4">
                Rp {{ number_format($court->price_per_hour) }} / jam
            </p>
                @if($court->bookings->count() > 0)
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                        Ada Booking
                    </span>

                    <div class="mt-3">
                        @foreach($court->bookings as $booking)
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </p>
                        @endforeach
                    </div>
                @else
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                        Tersedia
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection