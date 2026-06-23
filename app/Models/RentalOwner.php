<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOwner extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'tax_number',
        'nib',
        'ktp_image',
        'verification_status',
        'rejection_reason',
        'operating_hours',
        'whatsapp_number',
        'auto_confirm_booking',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}