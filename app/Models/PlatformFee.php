<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatformFee extends Model
{
    protected $fillable = [
        'payment_id',
        'fee_percent',
        'fee_amount',
    ];

    protected $casts = [
        'fee_percent' => 'decimal:2',
        'fee_amount'  => 'decimal:2',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}