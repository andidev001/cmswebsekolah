<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate([
            'id' => 1
        ], [
            'school_name' => 'SMK Yapisda Cisoka',
            'slogan' => 'Unggul, Berkarakter Islami & Berdaya Saing',
            'jenjang' => 'smk',
            'email' => 'info@smkyapisdacisoka.sch.id',
            'phone' => '(021) 5968123',
            'address' => 'Jl. Raya Cisoka No.15, Cisoka, Kec. Cisoka, Kabupaten Tangerang, Banten 15730',
        ]);

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->validate([
            'school_name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'jenjang' => 'required|string|in:sd,smp,sma,smk',
            'principal_name' => 'nullable|string|max:255',
            'principal_speech' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'maps_iframe' => 'nullable|string',
            'external_ppdb_link' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'theme' => 'required|string|in:default,emerald,crimson,amethyst,dark',
            'whatsapp_number' => 'nullable|string|max:50',
            'whatsapp_welcome_message' => 'nullable|string',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ppdb_active' => 'nullable|boolean',
            'ppdb_content' => 'nullable|string',
            'ppdb_requirements' => 'nullable|string',
            'ppdb_schedule' => 'nullable|string',
        ]);

        // Upload School Logo
        if ($request->hasFile('school_logo')) {
            if ($setting->school_logo && Storage::disk('public')->exists('settings/' . $setting->school_logo)) {
                Storage::disk('public')->delete('settings/' . $setting->school_logo);
            }
            $logoName = 'logo_' . time() . '.' . $request->school_logo->extension();
            $request->school_logo->storeAs('settings', $logoName, 'public');
            $data['school_logo'] = $logoName;
        }

        // Upload Principal Photo
        if ($request->hasFile('principal_photo')) {
            if ($setting->principal_photo && Storage::disk('public')->exists('settings/' . $setting->principal_photo)) {
                Storage::disk('public')->delete('settings/' . $setting->principal_photo);
            }
            $photoName = 'principal_' . time() . '.' . $request->principal_photo->extension();
            $request->principal_photo->storeAs('settings', $photoName, 'public');
            $data['principal_photo'] = $photoName;
        }

        $data['ppdb_active'] = $request->boolean('ppdb_active');

        $setting->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan sekolah berhasil diperbarui.'
        ]);
    }
}
