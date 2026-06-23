<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PlatformPolicy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = PlatformPolicy::latest()->paginate(15);
        return view('superadmin.policies.index', compact('policies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'type'    => 'required|in:sop,tos,faq,other',
        ]);

        PlatformPolicy::create([
            'title'     => $request->title,
            'content'   => $request->content,
            'type'      => $request->type,
            'is_active' => true,
        ]);

        return back()->with('success', 'Kebijakan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'type'    => 'required|in:sop,tos,faq,other',
        ]);

        $policy = PlatformPolicy::findOrFail($id);
        $policy->update([
            'title'     => $request->title,
            'content'   => $request->content,
            'type'      => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Kebijakan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PlatformPolicy::findOrFail($id)->delete();
        return back()->with('success', 'Kebijakan berhasil dihapus.');
    }
}
