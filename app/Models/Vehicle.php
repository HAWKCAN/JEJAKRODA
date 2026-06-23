<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    protected $fillable = [
        'rental_owner_id', 'name', 'type', 'plate_number',
        'price_per_day', 'location', 'status', 'image_url',
    ];

    // ── Relasi ────────────────────────────────────────────────
    public function rentalOwner()
    {
        return $this->belongsTo(RentalOwner::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ── Scopes ────────────────────────────────────────────────

    /** Hanya kendaraan yang tersedia */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    /**
     * Filter gabungan: type, harga min/max, lokasi, sort
     *
     * @param Builder $query
     * @param array   $filters  ['type','min_price','max_price','location','sort']
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price_per_day', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price_per_day', '<=', $filters['max_price']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        $sort = $filters['sort'] ?? 'price_asc';
        match ($sort) {
            'price_asc'  => $query->orderBy('price_per_day', 'asc'),
            'price_desc' => $query->orderBy('price_per_day', 'desc'),
            'newest'     => $query->latest(),
            default      => $query->orderBy('price_per_day', 'asc'),
        };

        return $query;
    }

    // ── Accessor ──────────────────────────────────────────────

    /** Rata-rata rating dari ulasan, 0 kalau belum ada ulasan */
    public function getAvgRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    /** Jumlah ulasan */
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    /** Label tipe yang lebih rapi */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'motor' => 'Motor',
            'mobil' => 'Mobil',
            default => ucfirst($this->type),
        };
    }

    /** Badge status */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'rented'    => 'Disewa',
            'inactive'  => 'Tidak Aktif',
            default     => $this->status,
        };
    }
}