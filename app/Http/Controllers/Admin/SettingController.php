<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

/**
 * Controller: Quản lý System Settings (Admin)
 */
class SettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string'],
        ]);

        foreach ($validated['settings'] as $key => $value) {
            $existing = SystemSetting::where('key', $key)->first();
            $group = $existing?->group;
            
            SystemSetting::set($key, $value, $group);
        }

        return back()->with('success', 'Đã cập nhật cấu hình.');
    }
}
