<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\SuperAdminSetting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SuperAdminSetting::pluck('value', 'key');

        return view('superadmin.settings.index', compact('settings'));
    }

    public function update(SettingRequest $request)
    {
        foreach ($request->validated() as $key => $value) {
            SuperAdminSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan platform berhasil disimpan.');
    }
}