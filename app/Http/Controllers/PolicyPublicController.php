<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PlatformPolicy;
use Illuminate\Http\Request;

class PolicyPublicController extends Controller
{
    public function index(Request $request)
    {
        $policies = PlatformPolicy::active()
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(9);

        // Tampilan berbeda untuk guest vs yang sudah login (user/manager),
        // tapi data dan route-nya sama.
        $view = auth()->check() ? 'policies.index_auth' : 'policies.index';

        return view($view, compact('policies'));
    }

    public function show($slug)
    {
        $policy = PlatformPolicy::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $view = auth()->check() ? 'policies.show_auth' : 'policies.show';

        return view($view, compact('policy'));
    }
}