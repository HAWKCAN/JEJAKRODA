<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\Review;
use App\Models\PlatformPolicy;


class HomeController extends Controller{

    public function index(Request $request)
    {
        $vehicleQuery = Vehicle::where('status', 'available');

        
        $vehicles = $vehicleQuery->latest()->take(8)->get();
        $heroVehicles = Vehicle::where('status', 'available')
            ->whereNotNull('image_url')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $stats = [
            'armada'     => Vehicle::count(),
            'pelanggan'  => User::where('role', 'user')->count(),
            'rating'     => round(Review::avg('rating') ?? 0, 1),
            'berdiri'    => 2020, 
        ];

      
        $sopCaraSewa = PlatformPolicy::where('type', 'sop')
            ->where('is_active', 1)
            ->first();

    
        return view('welcome', compact('vehicles', 'stats', 'heroVehicles', 'sopCaraSewa'));
    }
}