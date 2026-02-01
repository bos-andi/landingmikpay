<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        // Cek apakah user adalah admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // Ambil semua settings
        $settings = DB::table('settings')->pluck('value', 'key')->toArray();
        
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'trial_days' => 'nullable|integer|min:0|max:365',
            'trial_enabled' => 'nullable|boolean',
            'package_basic_price' => 'nullable|numeric|min:0',
            'package_premium_price' => 'nullable|numeric|min:0',
            'package_enterprise_price' => 'nullable|numeric|min:0',
        ]);

        $settings = [
            'trial_days' => $request->input('trial_days', 5),
            'trial_enabled' => $request->has('trial_enabled') ? 1 : 0,
            'package_basic_price' => $request->input('package_basic_price', 0),
            'package_premium_price' => $request->input('package_premium_price', 0),
            'package_enterprise_price' => $request->input('package_enterprise_price', 0),
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => is_numeric($value) ? 'integer' : 'string',
                    'updated_at' => now(),
                    'created_at' => DB::raw('COALESCE(created_at, NOW())'),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings berhasil diupdate'
        ]);
    }
}
