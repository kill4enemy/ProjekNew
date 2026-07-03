<?php

namespace App\Mail;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingConfirmedMail extends Mailable
{
    use SerializesModels;

    public function __construct(public Booking $booking) {}

    public function build()
    {
        $pdf = Pdf::loadView('pdf.booking-invoice', [
            'booking' => $this->booking,
        ]);

        return $this
            ->subject('Booking Berhasil Dikonfirmasi - Hans Padel')
            ->view('emails.booking-confirmed')
            ->attachData(
                $pdf->output(),
                'invoice-' . $this->booking->booking_code . '.pdf',
                ['mime' => 'application/pdf']
            );
    }
}