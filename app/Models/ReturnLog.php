<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnLog extends Model
{
    protected $fillable = [
        'booking_id',
        'returned_at',
        'late_fee',
        'condition',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
        'late_fee'    => 'decimal:2',
    ];

    /* ──────────────── Relationships ──────────────── */

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /* ──────────────── Helpers ──────────────── */

    public function isLate(): bool
    {
        return $this->late_fee > 0;
    }
}