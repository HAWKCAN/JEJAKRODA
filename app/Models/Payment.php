<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['booking_id','method','amount','status','proof_url','paid_at'];
    protected $casts = ['paid_at' => 'datetime'];
 
    public function booking()     { return $this->belongsTo(Booking::class); }
    public function platformFee() { return $this->hasOne(PlatformFee::class); }
}
