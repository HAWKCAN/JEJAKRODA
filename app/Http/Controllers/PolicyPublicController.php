<?php

namespace App\Http\Controllers;

use App\Models\PlatformPolicy;

class PolicyPublicController extends Controller
{
    public function index()
    {
        $policies = PlatformPolicy::where('is_active', true)->latest()->get();
        return view('policies.index', compact('policies'));
    }

    public function show($id)
    {
        $policy = PlatformPolicy::where('is_active', true)->findOrFail($id);
        return view('policies.show', compact('policy'));
    }
}