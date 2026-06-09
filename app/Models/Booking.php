<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'total_days',
        'subtotal',
        'platform_fee_amount',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date'           => 'date',
        'end_date'             => 'date',
        'subtotal'             => 'decimal:2',
        'platform_fee_amount'  => 'decimal:2',
        'total_price'          => 'decimal:2',
    ];

    /* ──────────────── Relationships ──────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function returnLog(): HasOne
    {
        return $this->hasOne(ReturnLog::class);
    }

    /* ──────────────── Helpers ──────────────── */

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'rejected'  => 'Ditolak',
            'completed' => 'Selesai',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'yellow',
            'confirmed' => 'blue',
            'rejected'  => 'red',
            'completed' => 'green',
            default     => 'gray',
        };
    }
}