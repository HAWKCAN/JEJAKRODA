<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class SuperAdminLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Activity::with('causer')
            ->when($request->log_name, fn($q) => $q->where('log_name', $request->log_name))
            ->when($request->search, fn($q) => $q->where('description', 'like', '%'.$request->search.'%'))
            ->latest()
            ->paginate(20);

        return view('superadmin.logs.index', compact('logs'));
    }
}