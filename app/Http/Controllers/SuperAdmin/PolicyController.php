<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PolicyController extends Controller
{
    public function index(){
        $policies = Policy::latest()->get();
        return view('superadmin.policies.index', compact('policies'));
    }

    public function store (Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Policy::create([
            'title' => $request->title,
            'slug'=> Str::slug($request->title),
            'content' => $request->content,

        ]);
        return back()->with('success', 'Kebijakan berhasil ditambahkan.');
    }

    public function update (Request $request,$id){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $policy = Policy::findOrFail($id);
        $policy->update([
            'title' => $request->title,
            'slug'=> Str::slug($request->title),
            'content' => $request->content,
        ]);
        return back()->with('success', 'Kebijakan berhasil diperbarui.');
    }

    public function destroy($id){
        Policy::findOrFail($id)->delete();
        return back()->with('success', 'Kebijakan berhasil dihapus.');
    }
}