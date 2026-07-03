@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
        Pembayaran Booking
    </h2>

    <p class="text-gray-700 dark:text-gray-200 mb-2">
        Kode Booking: {{ $booking->booking_code }}
    </p>

    <p class="text-gray-700 dark:text-gray-200 mb-4">
        Total: Rp {{ number_format($booking->total_price) }}
    </p>

    <button
        id="pay-button"
        class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700"
    >
        Bayar Sekarang
    </button>
</div>

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $booking->snap_token }}', {
            onSuccess: function () {
                window.location.href = '{{ route('payment.finish', $booking) }}';
            },
            onPending: function () {
                window.location.href = '{{ route('payment.finish', $booking) }}';
            },
            onError: function () {
                alert('Pembayaran gagal.');
            },
            onClose: function () {
                alert('Pembayaran belum diselesaikan.');
            }
        });
    });
</script>

@endsection