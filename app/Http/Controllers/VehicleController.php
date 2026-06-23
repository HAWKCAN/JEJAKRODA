<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * GET /vehicles
     * Katalog publik — bisa diakses tanpa login
     */
    public function index(Request $request)
    {
        $filters = $request->only(['type', 'min_price', 'max_price', 'location', 'sort', 'search']);

        $vehicles = Vehicle::available()
            ->filter($filters)
            ->when(!empty($filters['search']), function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%');
            })
            ->with('reviews')
            ->paginate(12)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles', 'filters'));
    }

    /**
     * GET /vehicles/{id}
     * Detail kendaraan + ulasan
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::with(['reviews.user', 'rentalOwner.user'])
            ->findOrFail($id);

        $ulasan = $vehicle->reviews()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Distribusi bintang
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $vehicle->reviews()->where('rating', $i)->count();
            $ratingDistribution[$i] = [
                'count'   => $count,
                'percent' => $vehicle->review_count > 0
                    ? round(($count / $vehicle->review_count) * 100)
                    : 0,
            ];
        }

        // Kendaraan serupa (same type, exclude current)
        $kendaraanSerupa = Vehicle::available()
            ->where('type', $vehicle->type)
            ->where('id', '!=', $vehicle->id)
            ->with('reviews')
            ->take(4)
            ->get();

        return view('vehicles.show', compact(
            'vehicle',
            'ulasan',
            'ratingDistribution',
            'kendaraanSerupa',
        ));
    }
}