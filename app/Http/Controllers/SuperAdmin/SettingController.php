<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdminSetting as Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('superadmin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'platform_fee_percent' => 'required|numeric|min:0|max:100',
            'app_name'             => 'required|string|max:100',
            'contact_email'        => 'required|email|max:100',
            'contact_phone'        => 'required|string|max:20',
        ]);

        $keys = ['platform_fee_percent', 'app_name', 'contact_email', 'contact_phone'];

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key'   => $key],
                ['value' => $request->input($key)]
            );
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}