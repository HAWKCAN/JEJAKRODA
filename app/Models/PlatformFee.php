<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformFee extends Model
{
     protected $fillable = ['payment_id','fee_percent','fee_amount','disbursed_status'];
 
    public function payment() { return $this->belongsTo(Payment::class); }
}
