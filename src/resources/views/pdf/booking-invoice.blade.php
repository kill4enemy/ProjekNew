<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 16px; margin-bottom: 24px; }
        .title { font-size: 26px; font-weight: bold; color: #1e3a8a; }
        .subtitle { color: #6b7280; margin-top: 4px; }
        .box { border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 18px; }
        .row { margin-bottom: 10px; }
        .label { font-weight: bold; width: 160px; display: inline-block; }
        .total { font-size: 20px; font-weight: bold; color: #2563eb; }
        .footer { margin-top: 30px; font-size: 12px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">Hans Padel</div>
    <div class="subtitle">Invoice Resmi Booking Lapangan</div>
</div>

<div class="box">
    <div class="row"><span class="label">Kode Booking</span> {{ $booking->booking_code }}</div>
    <div class="row"><span class="label">Nama Pemesan</span> {{ $booking->customer_name }}</div>
    <div class="row"><span class="label">No HP</span> {{ $booking->customer_phone }}</div>
    <div class="row"><span class="label">Email</span> {{ $booking->customer_email ?? '-' }}</div>
</div>

<div class="box">
    <div class="row"><span class="label">Lapangan</span> {{ $booking->facility->name }}</div>
    <div class="row"><span class="label">Tanggal</span> {{ $booking->booking_date }}</div>
    <div class="row"><span class="label">Jam</span> {{ $booking->start_time }} - {{ $booking->end_time }}</div>
    <div class="row"><span class="label">Status</span> CONFIRMED</div>
    <div class="row"><span class="label">Metode Bayar</span> {{ $booking->payment_type ?? 'Midtrans' }}</div>
</div>

<div class="box">
    <div class="row total">
        Total Pembayaran: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
    </div>
</div>

<div class="footer">
    Invoice ini diterbitkan otomatis oleh sistem Hans Padel.
</div>

</body>
</html>