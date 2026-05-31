<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOwner extends Model
{
    protected $fillable = [
        'user_id','business_name','business_address','tax_number','verification_status',
    ];
    public function user()     { return $this->belongsTo(User::class); }
    public function vehicles() { return $this->hasMany(Vehicle::class); }
}
