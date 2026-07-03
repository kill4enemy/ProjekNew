<h2>Booking Anda Telah Dikonfirmasi</h2>

<p>Halo {{ $booking->customer_name }},</p>

<p>Booking Anda telah dikonfirmasi oleh admin.</p>

<ul>
    <li>Kode Booking: {{ $booking->booking_code }}</li>
    <li>Lapangan: {{ $booking->facility->name }}</li>
    <li>Tanggal: {{ $booking->booking_date }}</li>
    <li>Jam: {{ $booking->start_time }} - {{ $booking->end_time }}</li>
    <li>Total: Rp {{ number_format($booking->total_price) }}</li>
    <li>Status: Confirmed</li>
</ul>

<p>Terima kasih telah menggunakan Hans Padel.</p>