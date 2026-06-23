<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Booking;
class DashboardController extends Controller
{   
public function index(Request $request)
{
    $userId = auth()->id();
    
    $vehicleQuery = Vehicle::where('status', 'available');
    
    // Filter by vehicle type if provided
    if ($request->has('type') && in_array($request->type, ['motor', 'mobil'])) {
        $vehicleQuery->where('type', $request->type);
    }
    
    if ($request->has('search') && trim($request->search) !== '') {
        $vehicleQuery->where('name', 'like', '%' . $request->search . '%');
    }
    
    $vehicles = $vehicleQuery->latest()->paginate(12);

    $pesananAktif = Booking::where('user_id', $userId)
        ->whereIn('status', ['pending', 'confirmed'])
        ->with(['vehicle', 'payment'])
        ->latest()
        ->get();

    $stats = [
        'total'     => Booking::where('user_id', $userId)->count(),
        'pending'   => Booking::where('user_id', $userId)->where('status', 'pending')->count(),
        'confirmed' => Booking::where('user_id', $userId)->where('status', 'confirmed')->count(),
        'completed' => Booking::where('user_id', $userId)->where('status', 'completed')->count(),
    ];

    return view('user.dashboard', compact('vehicles', 'pesananAktif', 'stats'));
}
}