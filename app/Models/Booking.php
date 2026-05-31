<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class Booking extends Model
{
    protected $fillable = [
        'user_id', 'vehicle_id', 'start_date', 'end_date',
        'total_days', 'subtotal', 'platform_fee_amount', 'total_price',
        'status', 'notes',
    ];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
 
    public function user()    { return $this->belongsTo(User::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}