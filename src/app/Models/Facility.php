<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'price_per_hour',
        'capacity',
        'is_active',
        'image',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'facility_id');
    }
}
