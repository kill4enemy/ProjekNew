<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'facility_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'booking_code',
        'snap_token',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'payment_type',
        'transaction_status',
        'payment_verified_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function court(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
