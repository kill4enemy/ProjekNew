<h2>Booking Anda Dibatalkan</h2>

<p>Halo {{ $booking->customer_name }},</p>

<p>Mohon maaf, booking Anda dibatalkan oleh admin.</p>

<ul>
    <li>Kode Booking: {{ $booking->booking_code }}</li>
    <li>Lapangan: {{ $booking->facility->name }}</li>
    <li>Tanggal: {{ $booking->booking_date }}</li>
    <li>Jam: {{ $booking->start_time }} - {{ $booking->end_time }}</li>
    <li>Status: Cancelled</li>
</ul>

<p>Silakan hubungi pihak Hans Padel untuk informasi lebih lanjut.</p>