@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">
    Booking Lapangan
</h2>

<div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-3xl shadow p-8">

<form action="{{ route('booking.store') }}" method="POST">
    @csrf

    @if (session('error'))
        <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KIRI --}}
        <div class="lg:col-span-1 space-y-5">

            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                Form Book
            </h3>

            <div class="rounded-xl overflow-hidden border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 h-64">
                <img
                    id="court-preview"
                    src=""
                    alt="Preview Lapangan"
                    class="w-full h-full object-cover hidden"
                >

                <div id="court-placeholder" class="w-full h-full flex items-center justify-center text-gray-500 dark:text-gray-300 text-center px-4">
                    Pilih lapangan untuk melihat gambar
                </div>
            </div>

            <div>
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Pilih Lapangan
                </label>

                <select
                    id="court-select"
                    name="facility_id"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                    @foreach($courts as $court)
                        <option
                            value="{{ $court->id }}"
                            data-image="{{ $court->image
                                ? (str_starts_with($court->image, 'images/')
                                    ? asset($court->image)
                                    : asset('storage/' . $court->image))
                                : '' }}"
                            data-price="{{ $court->price_per_hour }}"
                            @selected(old('facility_id') == $court->id)
                        >
                            {{ $court->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Durasi Permainan
                </label>

                <select
                    id="duration-select"
                    name="duration"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                    <option value="1" @selected(old('duration') == 1)>1 Jam</option>
                    <option value="2" @selected(old('duration') == 2)>2 Jam</option>
                    <option value="3" @selected(old('duration') == 3)>3 Jam</option>
                </select>
            </div>

        </div>

        {{-- KANAN --}}
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="md:col-span-2">
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Nama Pemesan
                </label>
                <input
                    type="text"
                    name="customer_name"
                    value="{{ old('customer_name') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                    required
                >
            </div>

            <div>
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Nomor HP
                </label>
                <input
                    type="text"
                    name="customer_phone"
                    value="{{ old('customer_phone') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                    required
                >
            </div>

            <div>
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Email
                </label>
                <input
                    type="email"
                    name="customer_email"
                    value="{{ old('customer_email') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                >
            </div>

            <div>
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Tanggal Reservasi
                </label>
                <input
                    type="date"
                    name="booking_date"
                    value="{{ old('booking_date') }}"
                    min="{{ now()->timezone('Asia/Jakarta')->format('Y-m-d') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>

            <div>
                <label class="block mb-2 text-gray-900 dark:text-white">
                    Jam Reservasi
                </label>
                <input
                    type="time"
                    name="start_time"
                    value="{{ old('start_time') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 p-3 rounded bg-white text-gray-900 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>

            <div class="md:col-span-2 pt-4">
                <div class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                    Total Pembayaran: <span id="total-price" class="text-blue-600 dark:text-blue-400">Rp 0</span>
                </div>
                <button class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                    Booking
                </button>
            </div>

        </div>

    </div>

</form>

</div>

<script>
    const courtSelect = document.getElementById('court-select');
    const courtPreview = document.getElementById('court-preview');
    const courtPlaceholder = document.getElementById('court-placeholder');
    const durationSelect = document.getElementById('duration-select');
    const totalPriceElement = document.getElementById('total-price');

    function updateCourtPreviewAndPrice() {
        const selectedOption = courtSelect.options[courtSelect.selectedIndex];
        const imageUrl = selectedOption?.dataset?.image;
        const pricePerHour = parseInt(selectedOption?.dataset?.price) || 0;
        const duration = parseInt(durationSelect.value) || 1;

        if (imageUrl) {
            courtPreview.src = imageUrl;
            courtPreview.classList.remove('hidden');
            courtPlaceholder.classList.add('hidden');
        } else {
            courtPreview.src = '';
            courtPreview.classList.add('hidden');
            courtPlaceholder.classList.remove('hidden');
        }

        const totalPrice = pricePerHour * duration;
        totalPriceElement.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }

    courtSelect.addEventListener('change', updateCourtPreviewAndPrice);
    if(durationSelect) {
        durationSelect.addEventListener('change', updateCourtPreviewAndPrice);
    }
    updateCourtPreviewAndPrice();
</script>

@endsection