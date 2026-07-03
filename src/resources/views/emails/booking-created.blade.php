<h2>Booking Anda Berhasil Dibuat</h2>

<p>Halo {{ $booking->customer_name }},</p>

<p>Pemesanan lapangan Anda telah berhasil dibuat. Silakan lakukan pembayaran agar jadwal Anda dapat dikonfirmasi secara otomatis.</p>

<h3>Detail Pemesanan:</h3>
<ul>
    <li>Kode Booking: {{ $booking->booking_code }}</li>
    <li>Lapangan: {{ $booking->facility->name }}</li>
    <li>Tanggal: {{ $booking->booking_date }}</li>
    <li>Jam: {{ $booking->start_time }} - {{ $booking->end_time }}</li>
    <li>Total Harga: Rp {{ number_format($booking->total_price) }}</li>
    <li>Status: Menunggu Pembayaran</li>
</ul>

<p><strong>Langkah Pembayaran:</strong></p>
<p>Silakan klik tautan berikut untuk melanjutkan proses pembayaran menggunakan Midtrans:</p>
<p><a href="{{ route('payment.show', $booking) }}" style="display: inline-block; padding: 10px 20px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 5px;">Selesaikan Pembayaran</a></p>

<p>Terima kasih telah menggunakan Hans Padel.</p>
