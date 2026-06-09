<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
        'proof_url',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount'  => 'decimal:2',
    ];

    /* ──────────────── Relationships ──────────────── */

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function platformFee(): HasOne
    {
        return $this->hasOne(PlatformFee::class);
    }

    /* ──────────────── Helpers ──────────────── */

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'transfer' => 'Transfer Bank',
            'cash'     => 'Tunai',
            'qris'     => 'QRIS',
            default    => ucfirst($this->method),
        };
    }
}